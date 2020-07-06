<?php

class ProtestCtrl {
  private $ID;
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
    $this->id = $protest->createProtest($protestData);

    return true;
  }

  public function loadProtest($protestID) {
    $protest = new Protest();
    $protestData = $protest->getProtest($protestID);

    $this->ID = $protestData[0]['id'];
    $this->seasonID = $protestData[0]['season_id'];
    $this->roundID = $protestData[0]['round_id'];
    $this->issuedBy = $protestData[0]['issued_by'];
    $this->protestedDriver = $protestData[0]['protested_driver'];
    $this->lap = $protestData[0]['lap'];
    $this->location = $protestData[0]['location'];
    $this->ytembed = $protestData[0]['yt_embed'];
    $this->description = $protestData[0]['description'];

    return true;
  }

  public function getProtestData() {
    $driver = new Driver();
    $issuedByDriver = $driver->getDriver($this->issuedBy);
    $issuedByName = $issuedByDriver[0]['display_name'];
    $protestedDriver = $driver->getDriver($this->protestedDriver);
    $protestedDriverName = $protestedDriver[0]['display_name'];

    $season = new Season();
    $season->seasonbyID($this->seasonID);
    $rounds = $season->getSeasonRounds();

    $protestData = array();

    $protestData['id'] = $this->ID;
    $protestData['seasonID'] = $this->seasonID;
    $protestData['roundID'] = $this->roundID;
    foreach ($rounds as $key => $value) {
      if($value['id'] == $this->roundID) {
        $protestData['round'] = 'Round '.$value['round_num'].' - '.$value['trackname'];
      }
    }
    $protestData['issuedBy'] = $this->issuedBy;
    $protestData['issuedByName'] = $issuedByName;
    $protestData['protestedDriver'] = $this->protestedDriver;
    $protestData['protestedDriverName'] = $protestedDriverName;
    $protestData['lap'] = $this->lap;
    $protestData['location'] = $this->location;
    $protestData['ytembed'] = $this->ytembed;
    $protestData['description'] = $this->description;

    return $protestData;

  }

}
