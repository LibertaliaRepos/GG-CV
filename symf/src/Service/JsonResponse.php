<?php
namespace App\Service;

use App\Entity\Author;

class JsonResponse {
    
    public function mailResponse(Author $author) {
            
        $authorP = (!empty($author->getName())) ? ' <strong>'. $author->getName() .'</strong>' : null;
    
        return <<< HERE
<h3>Message envoyé</h3>
<p>
  Merci Madame/Monsieur$authorP, <br />
  Votre message a bien été envoyé.
  Je vous répondrai dés que possible.
</p>
HERE;
    }
    
}