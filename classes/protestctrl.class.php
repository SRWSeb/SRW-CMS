<?php

class ProtestCtrl {
  private $seasonID;
  private $roundID;
  private $issuedBy;
  private $protestedDriver;
  private $lap;
  private $location;
  private $ytembed;
  private $description;

  public function setNewProtest($seasonID, $formData) {
    $this->seasonID = $seasonID;
    $this->roundID = $formData['round'];
    $this->issuedBy = $formData['issuedBy'];
    $this->protestedDriver = $formData['protestedDriver'];
    $this->lap = $formData['lap'];
    $this->location = $formData['location'];
    $this->ytembed = $formData['ytembed'];
    $this->description = $formData['description'];

    return true;
  }

  public function saveProtest() {
    $protestData = array();

    $protestData['seasonID'] = $this->seasonID;
    $protestData['roundID'] = $this->roundID;
    $protestData['issuedBy'] = $this->issuedBy;
    $protestData['protestedDriver'] = $this->protestedDriver;
    $protestData['lap'] = $this->lap;
    $protestData['location'] = $this->location;
    $protestData['ytembed'] = $this->ytembed;
    $protestData['description'] = $this->description;

    $protest = new Protest();
    $protest->createProtest($protestData);

    return true;
  }

}
