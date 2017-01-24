<?php $this->layout('layout', ['title' => $title, 'hours' => $hours ]) ?>

<?php foreach ($animals as $genotype => $individuals): ?>

<div class="row medium-10 large-8 columns">
  <div class="animal">
    <h3><?= $this->e($genotype) ?></h3>

    <div class="row small-up-2 medium-up-3 large-up-5">
    <?php foreach ($individuals as $index => $animal): ?>
      <div class="column animal animal--<?= $this->e($animal->getGenotype()) ?>">
        <div class="card">
          <img src="https://placehold.it/150x60?text=<?= $this->e($animal->getGenotype()) ?>+<?= $this->e($index + 1) ?>"
           class="thumbnail">
          <div class="card-section text-center">
            <h4><?= $this->e(sprintf("%.2f%%", $animal->getHealth())) ?></h4>
            <p><?= $this->e($animal->isAlive() ? 'Alive!' : 'Dead.') ?></p>
          </div>
        </div>
      </div>
    <?php endforeach ?>
    </div>


  </div>
</div>
<?php endforeach ?>

