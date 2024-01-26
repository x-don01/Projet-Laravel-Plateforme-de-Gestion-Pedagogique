<?php

namespace App\Http\Controllers;

use App\Models\annonces;
use App\Models\cheffiliere;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use App\Models\RepondAuDemande;
use Illuminate\Support\Facades\Auth;


    class ReclamationController extends Controller
{
    // public function createForm()
    // {
    //     return view('reclamations.create');
    // }

    public function store(Request $request)
    {
        $classe=Auth::guard('dlg')->user()->classe;
        // dd($classe);
        // Validation that the fields are not empty
        $form = $request->validate([
            
            'datashow' => 'nullable|boolean',
            'prise_internet' => 'nullable|boolean',
            'chaise' => 'nullable|boolean',
            'tableau' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

       $form['classe']=$classe;

        // Create a new instance of the Reclamation model and set the attributes
        $reclamation = new Reclamation($form);

        // Save the model to the database
        $reclamation->save();

        return redirect('/signaler')->with('success', 'Reclamation submitted successfully.');
    }

    
    public function repondaudemande(Request $request){
        // Validate the form data
        $request->validate([
            'type' => 'required',
            'to' => 'required',
            'message' => 'required',
        ]);
        if (Auth::check()) {
            // Retrieve the authenticated user's email and id
            $user = Auth::user();
            $from = $user->email;
            $profId = $user->id;
    
            // Create a new Demande model instance and save it to the database
            RepondAuDemande::create([
                'type' => $request->input('type'),
                'from' => $from,
                'to' => $request->input('to'),
                'message' => $request->input('message'),
                'id_prof' => $profId, // Set the id_prof
            ]);
    
            // Redirect back with a success message
            return redirect('/cheffiliere/demandes')->with('success', 'reponse envoyée avec succès!');
        } else {
            // User is not authenticated, handle accordingly (e.g., redirect to login)
            return redirect('/login')->with('error', 'Veuillez vous connecter avant de soumettre une demande.');
        }
    }



    //supprimer :
    public function supprimer(annonces $annonce)
    {
        dd($annonce);
        $annonce->delete();
        return redirect('/cheffiliere/annonces')->with('message', 'deleted successfully');
    }


    
   // Méthode pour afficher le formulaire de modification
    public function modifier($id)
    {
        // Fetch the annonce based on the id
        $annonce = Annonces::findOrFail($id);

        // Get the creator (professor's email) from the annonce
        $creator = $annonce->creator;

        // Fetch the professor's information from the database based on the email
        $CF = cheffiliere::where('email', $creator)->firstOrFail();

        // Extract the name and prenom
        $nom = $CF->nom;
        $prenom = $CF->prenom;

        return view('annonces.modifier_annoncesCF', compact('id', 'annonce', 'nom', 'prenom'));
    }


   // Méthode pour traiter le formulaire de modification
    public function update(Request $request, $id)
    {
        // Fetch the annonce based on the id
        $annonce = Annonces::findOrFail($id);

        // Fetch the professor's information from the database based on the email
        $professor = cheffiliere::where('email', $annonce->creator)->firstOrFail();
        $classe=Auth::guard('filier')->user()->filiere;

        // Extract the name and prenom
        $nom = $professor->nom;
        $prenom = $professor->prenom;

        // Mise à jour des données de l'annonce
        $annonce->update([
            'type' => $request->input('type'),
            'classe' => $classe,
            'description' => $request->input('description'),
        ]);

        // Redirection vers la page des annonces
        return redirect()->route('ChefFiliere.annonces', [
            'id' => $professor->id, // Assuming you want to use the professor's ID
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }
    public function reclamations(){

        $id = Auth::id();
        $nom = Auth::user()->nom; 
        $prenom = Auth::user()->prenom; 
        $classe = Auth::user()->filiere;
        $reclamation = Reclamation::where('classe', $classe)->get();
        return view('ChefFiliere.reclamations', [
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'reclamation' => $reclamation,
        ]);
    }
}


