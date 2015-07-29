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
		$get_note = $bdd->prepare("SELECT note,coefficient FROM notes WHERE `foreign_id_key_etudiant` = (SELECT id FROM etudiants WHERE id = :etudiant)");
		$get_note->bindParam(':etudiant',$_POST['etudiant']);
		$get_note->execute();
		$note=$get_note->fetchAll();

		$eleve=$_POST['etudiant'];
		$moyenne_generale = 0;
		$coefficient_general = 0;
		foreach ($note as $moyenne) {
			$moyenne_generale = $moyenne_generale+($moyenne['note']*$moyenne['coefficient']);
			$coefficient_general = $coefficient_general+$moyenne['coefficient'];
			
		}
		if ($coefficient_general != 0) {
		
		$moyenne_generale = $moyenne_generale / $coefficient_general;
		
		}
	}
?>
	<form method="post" action="#">
		<div>
			<select class="form-control" name="etudiant">
				<?php 
					foreach ($etudiants as $print_etudiant):
				?>
					<option value="<?=$print_etudiant['id']?>" name="id"><?=$print_etudiant['nom_prenom'];?></option>
				<?php
					endforeach;
				?>
			</select>




			<button type="submit" class="btn btn-primary" id="button">Calculer la moyenne</button>
		</div>
</form>

<?php
	if (isset($_POST['etudiant'])) {
		echo "La moyenne est de $moyenne_generale";
	}
?>