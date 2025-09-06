package com.example;
import com.example.graphes.GrapheNO;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.node.ArrayNode;
import com.fasterxml.jackson.core.type.TypeReference;

import java.io.File;
import java.util.*;

public class Recommender {
    public static void main(String[] args) throws Exception {
        // load data.json
        ObjectMapper mapper = new ObjectMapper();
        Map<String, Object> data = mapper.readValue(new File("../controller/AI/json-java1/data.json"), new TypeReference<Map<String, Object>>() {});

        Map<String, String> user = (Map<String, String>) data.get("user");
        String userLocation = user.get("location");

        List<Map<String, Object>> estArray = (List<Map<String, Object>>) data.get("establishments");
        List<Establishment> establishments = new ArrayList<>();
        Set<String> allLocations = new HashSet<>();

        for (Map<String, Object> est : estArray) {
            Establishment e = new Establishment(
                Integer.parseInt(est.get("id_establishment").toString()),
                (String) est.get("location"),
                Double.parseDouble(est.get("price").toString()),
                Integer.parseInt(est.get("stars").toString()),
                (String) est.get("type")
            );
            establishments.add(e);
            allLocations.add(e.location);
        }
        allLocations.add(userLocation);

        // Build graph
        GrapheNO graphe = new GrapheNO();
        for (String loc : allLocations) {
            graphe.ajouterSommet(loc);
        }
        for (String loc1 : allLocations) {
            for (String loc2 : allLocations) {
                if (!loc1.equals(loc2)) {
                    int distance = 10 + Math.abs(loc1.hashCode() - loc2.hashCode()) % 10;
                    graphe.ajouterArete(loc1, loc2, distance);
                }
            }
        }

        Map<String, List<ScoredEst>> scoredByType = new HashMap<>();
        for (Establishment e : establishments) {
            Map<String, Integer> heuristique = new HashMap<>();
            for (String loc : allLocations) {
                int heuristic = (int)(e.price * 0.5) + (5 - e.stars);
                heuristique.put(loc, heuristic);
            }

            List<String> path = graphe.AStar(userLocation, e.location, heuristique);
            if (path == null || path.size() < 2) continue;

            int pathCost = 0;
            for (int i = 0; i < path.size() - 1; i++) {
                Integer poids = graphe.getPoids(path.get(i), path.get(i + 1));
                if (poids != null) pathCost += poids;
            }

            int totalCost = pathCost + heuristique.get(e.location);

            scoredByType
                .computeIfAbsent(e.type, k -> new ArrayList<>())
                .add(new ScoredEst(e.id, totalCost));
        }

        List<Integer> recommendedIds = new ArrayList<>();
        for (String type : scoredByType.keySet()) {
            List<ScoredEst> list = scoredByType.get(type);
            list.sort(Comparator.comparingInt(s -> s.score));
            for (int i = 0; i < Math.min(3, list.size()); i++) {
                recommendedIds.add(list.get(i).id);
            }
        }

        // output to JSON file
        mapper.writeValue(new File("../controller/AI/recommended_establishments.json"), recommendedIds);
    }

    static class Establishment {
        int id;
        String location;
        double price;
        int stars;
        String type;

        Establishment(int id, String location, double price, int stars, String type) {
            this.id = id;
            this.location = location;
            this.price = price;
            this.stars = stars;
            this.type = type;
        }
    }

    static class ScoredEst {
        int id;
        int score;
        ScoredEst(int id, int score) {
            this.id = id;
            this.score = score;
        }
    }
}
