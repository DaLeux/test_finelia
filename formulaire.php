<?php
	include("navbar.html");
	include("connexion_bdd.php");

	$get_etudiants = $bdd->prepare("SELECT * FROM etudiants");
	$get_etudiants->execute();
	$etudiants=$get_etudiants->fetchAll();

	$get_matiere = $bdd->prepare("SELECT * FROM matiere");
	$get_matiere->execute();
	$matiere=$get_matiere->fetchAll();

	if(isset($_POST['etudiant']) && isset($_POST['matiere']) && isset($_POST['note']) && !empty($_POST['note'])){
		$set_note = $bdd->prepare("INSERT INTO notes (foreign_key_matiere, foreign_key_etudiant, note)
									VALUES (
									  (SELECT id
									   FROM matiere
									   WHERE nom = :matiere),
									  (SELECT id
									   FROM etudiants
									   WHERE nom_prenom = :etudiant),
									  :note)");
		$set_note->bindParam(':matiere',$_POST['matiere']);
		$set_note->bindParam(':etudiant',$_POST['etudiant']);
		$set_note->bindParam(':note',$_POST['note']);
		$note=$set_note->execute();

	}

?>
	<form method="post" action="#">
		<div>
			<input type="text" placeholder="nom prenom" name="etudiant"/>
			<select class="form-control" name="matiere">
				<?php 
					foreach ($matiere as $print_matiere) {
				?>
					<option><?=$print_matiere['nom'];?></option>
				<?php } ?>
			</select>
			<input type="text" class="form-control" placeholder="Note" name="note" />
			<button type="submit" class="btn btn-primary" id="button">Enregistrer</button>
		</div>
	</form>
</body>
</html>