<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Prof;
use App\Models\Etudiant;
use App\Models\cheffiliere;
use Illuminate\Http\Request;
use App\Models\ChefDepartement;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function AuthLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Check if 'email' key exists in $credentials
    if (!array_key_exists('email', $credentials)) {
        return redirect()->back()->withInput($request->only('email'))->with('error', 'Veuillez fournir une adresse e-mail.');
    }

    $userType = $this->getUserType($credentials['email']);

    if (Auth::guard($userType)->attempt($credentials, true)) {
        // Retrieve the authenticated user
        $user = Auth::guard($userType)->user();

        // Redirect to the appropriate dashboard based on user type and ID
        return $this->redirectToDashboard($userType, $user->id);
    } else {
        return redirect()->back()->withInput($request->only('email'))->with('error', 'Adresse e-mail ou mot de passe incorrect.');
    }
}


    private function getUserType($email)
    {
        if (strpos($email, '@admin.com') !== false) {
            return 'admin';
        } elseif (strpos($email, '@etudiant.com') !== false) {
            return 'etudiant';
        } elseif (strpos($email, '@prof.com') !== false) {
            return 'prof';
        } elseif (strpos($email, '@filier.com') !== false) {
            return 'filier';
        } elseif (strpos($email, '@departement.com') !== false) {
            return 'departement';
        }elseif (strpos($email, '@dlg.com') !== false){
            return 'dlg';
        }
        else {
            return 'unknown';
        }
    }

    private function redirectToDashboard($userType, $id)
    {
        switch ($userType) {
            case 'admin':
                // Retrieve the admin data
                $admin = Admin::find($id);
        
                // Check if the chefdepartement is found
                if ($admin) {
                    // Redirect to the chefdepartement dashboard with the chefdepartement data
                    return redirect()->route('admin.dashbord', [
                        'id' => $id,
                        'nom' => $admin->nom,
                        'prenom' => $admin->prenom,
                        
                    ]);
                } else {
                    // chefdepartement not found, handle accordingly
                    return redirect()->back()->withInput();
                }
                break;
            case 'etudiant':
                 // Retrieve the etudiant data
                 $etudiant = Etudiant::find($id);
        
                 // Check if the etudiant is found
                 if ($etudiant) {
                     // Redirect to the etudiant dashboard with the etudiant data
                     return redirect()->route('etudiant.home', [
                         'id' => $id,
                         'nom' => $etudiant->nom,
                         'prenom' => $etudiant->prenom,
                     ]);
                 } else {
                     // etudiant not found, handle accordingly
                     return redirect()->back()->withInput();
                 }
             break;
            case 'prof':
                    // Retrieve the professor data
                    $professor = Prof::find($id);
        
                    // Check if the professor is found
                    if ($professor) {
                        // Redirect to the prof dashboard with the professor data
                        return redirect()->route('prof.prof_welcome', [
                            'id' => $id,
                            'nom' => $professor->nom,
                            'prenom' => $professor->prenom,
                        ]);
                    } else {
                        // Professor not found, handle accordingly
                        return redirect()->back()->withInput();
                    }
                break;
                case 'filier':
                    // Retrieve the professor data
                    $ChefFiliere = cheffiliere::find($id);
            
                    // Check if the professor is found
                    if ($ChefFiliere) {
                        // Redirect to the prof dashboard with the professor data
                        return redirect()->route('ChefFiliere.welcome', [
                            'id' => $id,
                            'nom' => $ChefFiliere->nom,
                            'prenom' => $ChefFiliere->prenom,
                        ]);
                    } else {
                        // Professor not found, handle accordingly
                        return redirect()->back()->withInput();
                    }
                break;
            case 'departement':
                // Retrieve the chefdepartement data
                $chefdepartement = ChefDepartement::find($id);
        
                // Check if the chefdepartement is found
                if ($chefdepartement) {
                    // Redirect to the chefdepartement dashboard with the chefdepartement data
                    return redirect()->route('chefdepartement.dashbord', [
                        'id' => $id,
                        'nom' => $chefdepartement->nom,
                        'prenom' => $chefdepartement->prenom,
                        'departement'=>$chefdepartement->departement,
                    ]);
                } else {
                    // chefdepartement not found, handle accordingly
                    return redirect()->back()->withInput();
                }
            break;
            case 'dlg':
                $dlg = Etudiant::find($id);
    
                if ($dlg) {
                    // Change the route to 'delegue.home'
                    return redirect()->route('delegue.home', [
                        'id' => $id,
                        'nom' => $dlg->nom,
                        'prenom' => $dlg->prenom,
                    ]);
                } else {
                    return redirect()->back()->withInput();
                }
                break;

            default:
                // Handle the case for 'unknown' user type
                break;
        }
    }
    public function logout()
{
    Auth::logout();
    session()->flush(); // Clear all session data
    return redirect('/invite/login'); // or any other URL you want to redirect to after logout
}
}
