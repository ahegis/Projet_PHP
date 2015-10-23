<?php
	include("header.html");

		?>
			<label for="fonc_dev">Liste des Fonctions Implémentées</label>
			<ul name="fonc_dev">
				<li>Table Coureur : <ul>
					<li><a href="../Coureur/form_coureur_add.php">Ajout</a></li>
					<li><a href="../Coureur/form_coureur_look.php">Consultation</a></li>
					<li>Modification</li>
					<li>Suppression</li></ul>
				</li>
				<br/><li>Table Annee : <ul>
					<li><a href="../Annee/form_annee_add.php">Ajout</a></li>
					<li><a href="../Annee/form_annee_look.php">Consultation</a></li>
					<li>Modification</li>
					<li>Suppression</li></ul>
				</li>
				<br/><li>Table Epreuve : <ul>
					<li>Ajout</li>
					<li>Consultation</li></ul>
				</li>
			</ul>


		<?php
		include("footer.html");
		?>