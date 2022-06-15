<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use \Core\View;

/**
 * Product controller
 */
class Product extends \Core\Controller
{

    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
    {

        if(isset($_POST['submit'])) {

            try {
                $f = $_POST;

                // TODO: Validation

                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                $pictureName = Upload::uploadFile($_FILES['picture'], $id);

                Articles::attachPicture($id, $pictureName);

                header('Location: /product/' . $id);
            } catch (\Exception $e){
                    var_dump($e);
            }
        }

        View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];
        $f = $_POST;

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch(\Exception $e){
            var_dump($e);
        }

        if(isset($_POST['sendMail']))
        {
            $this->sendMailAction($f);
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }

    private function sendMailAction($data)
    {   
        if(isset($data['email']) and isset($data['message']))
        {   

            $destinataire = 'vanhuysse1@gmail.com';
            $email = htmlentities($data['email']);
            if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',str_replace('&amp;','&',$email)))
            {
                $sujet = 'Contact';
                $message = stripslashes($data['message']);
                $headers = "From: <".$email.">\n";
                $headers .= "Reply-To: ".$email."\n";
                $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
                if(mail($destinataire,$sujet,$message,$headers))
                    {
                    echo "<p class='message'>Votre message a bien &eacute;t&eacute; envoy&eacute;.</p>";
                    }
                else
                    {
                    echo "<p class='message'>Une erreur c'est produite lors de l'envois du message.</p>";
                    }
            }
            else
            {
                echo "<p class='message'>L'email que vous avez entr&eacute; est invalide.</p>";
            }
        }
        else
        {

        }
    }
}