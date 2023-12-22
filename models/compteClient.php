<?php
    require_once("$ROOT_PATH/models/objet.php");

class compteClient extends objet {
    public static $classe = "compteClient";
    public static $identifiant = "idClient";

    public int $id;
    public string $prenom;
    public string $nom;
    public string $email;
    public string $tel;
    public string $mdpHash;
    public string $urlPhotoProfil;
    public int $ptsFidelite;

    public function __construct($id, $prenom, $nom, $email, $tel, $mdpHash, $urlPhotoProfil, $ptsFidelite)
    {
        parent::__construct();
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->tel = $tel;
        $this->mdpHash = $mdpHash;
        $this->urlPhotoProfil = $urlPhotoProfil;
        $this->ptsFidelite = $ptsFidelite;
    }

}
?>