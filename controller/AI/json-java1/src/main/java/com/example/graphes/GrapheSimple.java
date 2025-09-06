package com.example.graphes;

import java.util.Collection;
import java.util.Set;


public interface GrapheSimple <T extends Collection<String>> {
    
    void ajouterSommet(String sommet);
    
    void ajouterArete(String sommet1, String sommet2, Integer poids);

    Integer getPoids(String sommet1, String sommet2);

    Collection<String> getVoisins(String sommet);

    Collection<String> Sommets();

    Set<T> Aretes();

    boolean estConnexe();
    
}