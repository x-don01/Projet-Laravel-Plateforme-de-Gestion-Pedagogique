<?php
namespace App\Http\Controllers;
use App\Models\prof;
use App\Models\Annonces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnoncesController extends Controller
{
    public function show($id, $nom, $prenom)
    {
        
        return view('annonces.create', compact('id', 'nom', 'prenom'));
    }

    

    public function store(Request $request)
    {
        // Check if there's an authenticated professor
        if (Auth::guard('prof')->check()) {
            // Get the authenticated professor's email
            $profId = Auth::guard('prof')->user()->email;

            // Validation that the fields are not empty
            $form = $request->validate([
                'type' => 'required',
                'classe' => 'required',
                'description' => 'required',
            ]);

            // Set the id_prof with the authenticated professor's ID
            $form['creator'] = $profId;
           
         

            // Create a new instance of the model and set the attributes
            $annonce = new Annonces($form);

            // Save the model to the database
            $annonce->save();

            return redirect('/prof/prof_annonces');
            // return view('prof.prof_welcome', compact('id', 'nom', 'prenom'));
        } else {
            // Handle the case when there's no authenticated professor
            return redirect()->back()->withInput()->withErrors(['auth' => 'Authentication failed.']);
        }
    }

    //supprimer :
    public function supprimer(annonces $annonce)
    {
        $annonce->delete();
        return redirect('/prof/prof_annonces')->with('message', 'deleted successfully');
    }

    
   // Méthode pour afficher le formulaire de modification
    public function modifier($id)
    {
        // Fetch the annonce based on the id
        $annonce = Annonces::findOrFail($id);

        // Get the creator (professor's email) from the annonce
        $creator = $annonce->creator;

        // Fetch the professor's information from the database based on the email
        $professor = prof::where('email', $creator)->firstOrFail();

        // Extract the name and prenom
        $nom = $professor->nom;
        $prenom = $professor->prenom;

        return view('annonces.modifier_annonces', compact('id', 'annonce', 'nom', 'prenom'));
    }


   // Méthode pour traiter le formulaire de modification
    public function update(Request $request, $id)
    {
        // Fetch the annonce based on the id
        $annonce = Annonces::findOrFail($id);

        // Fetch the professor's information from the database based on the email
        $professor = prof::where('email', $annonce->creator)->firstOrFail();

        // Extract the name and prenom
        $nom = $professor->nom;
        $prenom = $professor->prenom;

        // Mise à jour des données de l'annonce
        $annonce->update([
            'type' => $request->input('type'),
            'classe' => $request->input('classe'),
            'description' => $request->input('description'),
        ]);

        // Redirection vers la page des annonces
        return redirect()->route('prof.prof_annonces', [
            'id' => $professor->id, // Assuming you want to use the professor's ID
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }


    // partie de chef filiere

    public function showCF()
    {
        $id = Auth::id();
        $nom = Auth::user()->nom; 
        $prenom = Auth::user()->prenom; 
        return view('annonces.ChefFiliere_create', compact('id', 'nom', 'prenom'));
    }

}