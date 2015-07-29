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
		$set_note_coefficient = $bdd->prepare("INSERT INTO notes (foreign_id_key_matiere, foreign_id_key_etudiant, note, coefficient)
									VALUES (
									  (SELECT id
									   FROM matiere
									   WHERE nom = :matiere),
									  (SELECT id
									   FROM etudiants
									   WHERE nom_prenom = :etudiant),
									    :note,
										:coefficient)");
		$set_note_coefficient->bindParam(':matiere',$_POST['matiere']);
		$set_note_coefficient->bindParam(':etudiant',$_POST['etudiant']);
		$set_note_coefficient->bindParam(':note',$_POST['note']);
		$set_note_coefficient->bindParam(':coefficient',$_POST['coefficient']);
		$note=$set_note_coefficient->execute();

		
	}

?>
	<form method="post" action="#">
		<div>
			<select class="form-control" placeholder="Nom de l'élève" name="etudiant">
				<?php
					foreach ($etudiants as $print_etudiant) {
				?>
					<option><?=$print_etudiant['nom_prenom']?></option>
				<?php	}
				?>
			</select>
			<!--<input type="text" placeholder="nom prenom" name="etudiant"/>-->
			<select class="form-control" name="matiere">
				<?php 
					foreach ($matiere as $print_matiere) {
				?>
					<option><?=$print_matiere['nom'];?></option>
				<?php } ?>
			</select>
			<input type="text" class="form-control" placeholder="Note" name="note" />
			<input type="text" class="form-control" placeholder="Coefficient" name="coefficient"/>
			<button type="submit" class="btn btn-primary" id="button">Enregistrer</button>
		</div>
	</form>
</body>
</html>