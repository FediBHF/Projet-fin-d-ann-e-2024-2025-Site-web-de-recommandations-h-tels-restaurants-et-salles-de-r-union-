package com.example.algorithmes;
import java.util.*;
import com.example.graphes.*;

public class AlgorithmeAStar {
    
    public List<String> AStar(GrapheNO graph, String start, String goal, Map<String, Integer> h) {
        Set<String> visite = new HashSet<>();
        Map<String,String> noeudPrecedent = new HashMap<>();
        
        Map<String, Integer> gScore = new HashMap<String,Integer>();
        for(String s : graph.Sommets()) {
            gScore.put(s, Integer.MAX_VALUE);
        }
        gScore.put(start, 0);

        Map<String, Integer> fScore = new HashMap<String,Integer>();
        for(String s : graph.Sommets()) {
            fScore.put(s, Integer.MAX_VALUE);
        }
        fScore.put(start, h.get(start));
        
        visite.add(start);

        String sommetCourant;
        String temp;
        while(!visite.isEmpty()) {
            temp = visite.iterator().next();
            for(String s : visite)
                if(fScore.get(s) < fScore.get(temp))
                    temp = s;
            sommetCourant = temp;

            if(sommetCourant.equals(goal))
                return reconstructPath(noeudPrecedent, sommetCourant);

            visite.remove(sommetCourant);
            
            for(String voisin : graph.getVoisins(sommetCourant)){
                Set<String> arete = new HashSet<>();
                arete.add(sommetCourant);
                arete.add(voisin);
                int tentative_gScore = gScore.get(sommetCourant) + graph.getPoids(arete);
                if(tentative_gScore < gScore.get(voisin)) {
                    noeudPrecedent.put(voisin, sommetCourant);
                    gScore.put(voisin, tentative_gScore);
                    fScore.put(voisin, tentative_gScore + h.get(voisin));
                    if(!visite.contains(voisin))
                        visite.add(voisin);
                }
            }
        }
        
        return Collections.emptyList();
    }
    
    private static List<String> reconstructPath(Map<String, String> noeudPrecedent, String courant) {
        LinkedList<String> path = new LinkedList<>();
        path.addFirst(courant);
        while (noeudPrecedent.containsKey(courant)) {
            courant = noeudPrecedent.get(courant);
            path.addFirst(courant);
        }
        return path;
    }
}
