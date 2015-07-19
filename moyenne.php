<?php
	include("navbar.html");
	include("connexion_bdd.php");

	$get_etudiants = $bdd->prepare("SELECT * FROM etudiants");
	$get_etudiants->execute();
	$etudiants=$get_etudiants->fetchAll();

	

	$get_matiere = $bdd->prepare("SELECT * FROM matiere");
	$get_matiere->execute();
	$matiere=$get_matiere->fetchAll();

	

	if (isset($_POST['etudiant'])) {
		$get_note = $bdd->prepare("SELECT note,coefficient FROM notes INNER JOIN matiere WHERE foreign_key_etudiant = :id_etudiant AND notes.foreign_key_matiere = matiere.id");
		//$get_note = $bdd->prepare("SELECT note,coefficient FROM notes INNER JOIN matiere WHERE foreign_key_etudiant = 1 AND notes.foreign_key_matiere = matiere.id");
		$get_note->bindParam(':id_etudiant',$print_etudiant['id']);
		$get_note->execute();
		$moyenne=$get_note->fetchAll();

		echo '<pre>';
		var_dump($moyenne);
		echo "<pre>";
		/*foreach ($note as $moyenne_generale){
			$moyenne_etudiant=$moyenne['note']*$moyenne['coefficient'];
		}

		echo $moyenne_etudiant;*/
	}
?>
	<form method="post" action="#">
		<div>
			<select class="form-control" name="etudiant">
				<?php 
					foreach ($etudiants as $print_etudiant) {
				?>
					<option><?=$print_etudiant['nom_prenom'];?></option>
					
				<?php } ?>
			</select>
			<button type="submit" class="btn btn-primary" id="button">Calculer la moyenne</button>
		</div>
</form>

