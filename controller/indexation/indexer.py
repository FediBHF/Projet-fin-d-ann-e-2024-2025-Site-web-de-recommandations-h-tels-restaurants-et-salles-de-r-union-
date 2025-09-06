import json
import os
import subprocess
import nltk # type: ignore
from nltk.tokenize import word_tokenize # type: ignore
from nltk.corpus import stopwords # type: ignore

# Download necessary NLTK resources (first time only)
nltk.download('punkt')
nltk.download('stopwords')

# Use full list of English stopwords from NLTK
STOPWORDS = set(stopwords.words('english'))

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
data_path = os.path.join(BASE_DIR, "establishment_data.json")
index_path = os.path.join(BASE_DIR, "establishment_index.json")

def create_index(establishments):
    index = {}
    for est in establishments:
        name = est.get('name', '').strip()
        location = est.get('location', '').strip()
        description = est.get('description', '').strip()

        print(f"Processing: {name}, {location}, {description}")  # Debug print

        # Combine and tokenize
        combined_text = f"{name} {location} {description}".lower()
        tokens = word_tokenize(combined_text)

        # Clean tokens: remove stopwords and punctuation
        keywords = set()
        for token in tokens:
            token = token.strip(".,!?;:'’\"()[]{}")  # basic punctuation cleanup
            if token and token not in STOPWORDS:
                keywords.add(token)

        for word in keywords:
            if word not in index:
                index[word] = []
            if est not in index[word]:
                index[word].append({
                    'name': name,
                    'location': location,
                    'description': description
                })


    # save to json
    with open(index_path, 'w', encoding='utf-8') as f:
        json.dump(index, f, ensure_ascii=False, indent=4)

    print(f"indexation terminée avec succès. {len(index)} keys indexed.")

# main
try:
    # check if data_path is empty
    fetch_data = False
    if not os.path.exists(data_path) or os.path.getsize(data_path) == 0:
        print(f"{data_path} is missing or empty, fetching data...")
        fetch_data = True
    else:
        with open(data_path, "r", encoding="utf-8") as f:
            data = json.load(f)
            if data == {}:
                print(f"{data_path} is empty, fetching data...")
                fetch_data = True

    if fetch_data:
        curl_command = f"curl -o {data_path} localhost/RoamMate/controller/indexation/getEstData.php"
        try:
            result = subprocess.run(curl_command, shell=True, capture_output=True, text=True)
            if result.returncode != 0:
                raise RuntimeError(f"curl failed: {result.stderr}")
            print(f"curl succeeded, data saved to {data_path}")
        except Exception as e:
            raise RuntimeError(f"failed to run curl: {str(e)}")

    # create the index
    with open(data_path, "r", encoding="utf-8") as f:
        data = json.load(f)
    establishments = data.get('establishments', [])
    create_index(establishments)

except Exception as e:
    print(f"❌ une erreur est survenue : {str(e)}")