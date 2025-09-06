package com.example.graphes;

import java.util.Map;
import java.util.HashMap;
import java.util.Set;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Queue;
import java.util.LinkedList;
import java.util.List;

import com.example.algorithmes.*;

public class GrapheNO implements GrapheSimple <Set<String>>{

	private Map<Set<String>, Integer> listAdj = new HashMap<Set<String>, Integer>();
	
	@Override
	public Set<Set<String>> Aretes() {
		Set<Set<String>> ensemble_Aretes = listAdj.keySet();
		return ensemble_Aretes;
	}

	@Override
	public Set<String> Sommets() {
		Set<String> ensemble_Sommets = new HashSet<>();

		Set<Set<String>> ensemble_Aretes = this.Aretes();
		Iterator<Set<String>> iterator = ensemble_Aretes.iterator();
		while(iterator.hasNext()) {
			Set<String> arete = iterator.next();
			for(String s: arete)
				ensemble_Sommets.add(s);
		}

		return ensemble_Sommets;
	}

	@Override
	public void ajouterSommet(String sommet) {
		if(listAdj.isEmpty()){
			Set<String> areteSingleton = new HashSet<>();
			areteSingleton.add(sommet);
			listAdj.put(areteSingleton, 0);
			return;
		}

		Set<String> ensemble_Sommets = this.Sommets();
		if(ensemble_Sommets.contains(sommet)){
			System.out.println("Sommet " + sommet + " deja existant dans le graphe");
			return;
		}
		else{
			Iterator<String> iterator = ensemble_Sommets.iterator();
			while(iterator.hasNext()) {
				String s = iterator.next();
				Set<String> arete = new HashSet<>();
				arete.add(s);
				if(ensemble_Sommets.size() == 1)
					listAdj.remove(arete);
				arete.add(sommet);
				listAdj.put(arete, 0);
			}
		}
		
	}
	
	@Override
	public void ajouterArete(String sommet1, String sommet2, Integer poids) {
		if(sommet1.equals(sommet2)) return;
		if(poids >= 0) {
			Set<String> newArete = new HashSet<>();
			newArete.add(sommet1);
			newArete.add(sommet2);
			listAdj.put(newArete, poids);
		}
		else
			System.out.println("Poids negatif, try again");
	}
	public void ajouterArete(Set<String> arete, Integer poids) {
		if(poids >= 0)
			listAdj.put(arete, poids);
		else
			System.out.println("Poids negatif, try again");
	}

	@Override
	public Integer getPoids(String sommet1, String sommet2) {
		Set<String> arete = new HashSet<>();
		arete.add(sommet1);
		arete.add(sommet2);
		return listAdj.get(arete); //va retourner null si l'arete n'existe pas
	}
	public Integer getPoids(Set<String> arete) {
		return listAdj.get(arete); //va retourner null si l'arete n'existe pas
	}

	@Override
	public Set<String> getVoisins(String sommet) {
		Set<String> voisins = new HashSet<>();
		for(Set<String> arete : this.Aretes())
			if(arete.contains(sommet) && listAdj.get(arete) > 0)
				for(String s : arete)
					if(!s.equals(sommet))
						voisins.add(s);
		return voisins;
	}

	@Override
	public boolean estConnexe() {
		Map<String, Boolean> visited = new HashMap<>();
		for(String sommet : this.Sommets())
			visited.put(sommet, false);
		
		if(visited.size() >= 2){
			Queue<String> file = new LinkedList<>();
			String sommetDepart;
			Iterator<String> iterator = this.Sommets().iterator();
			sommetDepart = iterator.next();
			file.add(sommetDepart);
				
			while(!file.isEmpty()) {
				String courant = file.poll();
				for(String voisin : this.getVoisins(courant)) {
					if(!visited.get(voisin)) {
						file.add(voisin);
						visited.put(voisin, true);
					}
				}
			}

			for(String sommet : this.Sommets()) 
				if(!visited.get(sommet))
					return false;
		    return true;
		}
		else
			return false;
	}

	public List<String> AStar(String source, String destination, Map<String, Integer> heuristique) {
		AlgorithmeAStar temp = new AlgorithmeAStar();
		return temp.AStar(this, source, destination, heuristique);
	}

	public void afficherMatrice() {
		List<String> sommets = new LinkedList<>(this.Sommets());
		System.out.print("   "); for(String s : sommets) System.out.print(s + "  ");
		System.out.println();
		for(String s1 : sommets){
			System.out.print(s1 + "  ");
			for(String s2 : sommets) {
				Integer poids = this.getPoids(s1, s2);
				if(poids != null)
					System.out.print(poids + "  ");
				else
					System.out.print("0  ");
			}
			System.out.println();
		}
	}

}
