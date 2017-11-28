
<p>
<span class="w3-tag w3-jumbo w3-black"><?= $_POST['PRIX'] ?> € <span class="w3-large">TTC</span></span>
</p>
<hr>
<div class="w3-left-align">
  <p>Distance : <?= $_POST['KM'] ?> km</p>
  <p>Durée : <?= $_POST['TIME'] ?> minutes</p>
</div>
<hr>
<p>
<a href="reservation/<?= $_POST['REF'] ?>">
<button class="w3-btn w3-green w3-padding-large"> RESERVEZ <span class="w3-hide-small">MAINTENANT</span></button>
</a>
</p>