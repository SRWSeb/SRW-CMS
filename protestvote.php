<?php
require 'header.php';
?>

<div class="container">
  <div class="row">
    <div class="col">
      <h1>Simracersworld GT PRO Series</h1>
      <h2>Round 10: Road America</h2>
    </div>
  </div>
  <div class="row">
    <div class="col d-flex justify-content-center">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/CNMttCNoBZ8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="col">
      <h4>Issued by: </h4><p>Bod Boland</p>
      <h4>Protested Driver: </h4><p>Dave Fuller</p>
      <h4>Lap: </h4><p>1</p>
      <h4>Location: </h4><p>Approaching Turn 3</p>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h4>Description given by driver:</h4>
      <p>As I've got on the brakes for T3 I was hit from behind by Fuller. This sent me across the track, in to the wall/fence and forced me to tow due to broken steering. Almost 12 minutes of repairs required, plus more optional repairs, I retired.</p>
    </div>
  </div>
  <form>
    <div class="row">
      <fieldset class="form-group">
        <legend class="col">Verdict:</legend>
        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="verdict" id="guilty" value="1">
            <label class="form-check-label" for="guilty">
              Guilty
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="verdict" id="nguilty" value="0">
            <label class="form-check-label" for="nguilty">
              Not guilty
            </label>
          </div>
        </div>
      </fieldset>
    </div>
    <div class="row">
      <div class="col">
      <div class="form-group">
        <label for="reasoning">Comment:</label>
        <textarea class="form-control" id="reasoning" rows="5"></textarea>
      </div>
    </div>
    </div>
    <button type="submit" class="btn btn-secondary">Submit</button>
  </form>
</div>

<?php
require 'footer.php';
?>
