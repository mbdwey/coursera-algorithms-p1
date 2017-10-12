<?php
/*
Social network connectivity. Given a social network containing n members and a log file containing m timestamps at which times pairs of members formed friendships, design an algorithm to determine the earliest time at which all members are connected (i.e., every member is a friend of a friend of a friend ... of a friend). Assume that the log file is sorted by timestamp and that friendship is an equivalence relation. The running time of your algorithm should be mlog⁡n or better and use extra space proportional to n.

Note: these interview questions are ungraded and purely for your own enrichment. To get a hint, submit a solution.
 */

/**
*     My implementation
*/
// 1507838424
class SocialNetworkConnectivity
{
  public $members = [];

  // constructing demo data
  /*
    assuming log file will contains data like
    timestamps [memberID,memberID]

    assuming that after reading log file we got this array
    memberID [
      addedMemberID
      timestamps
    ]

   */
  public $friendshipsLogs = [
    // demo data
    [1507838424,1,2],
    [1507838424,3,4],
    [1507838424,3,1],
  ];
  private $size = [];



  function __construct($n,$m)
  {
    // simulating demo members
    for ($i=1; $i <= $n; $i++) {
      $this->members[$i] = $i;
    }
    // init size
    $this->setDefaultSize();
    // print_r($this->members);
    foreach ($this->friendshipsLogs as $friendshipsLogEntry)
    {
      $this->union($friendshipsLogEntry[1],$friendshipsLogEntry[2]);
    }
    // print_r($this->members);
    print_r($this->size);
    print($this->rootLog(3));
    print($this->rootLog(4));
    print($this->rootLog(1));
    print($this->rootLog(2));
    // simulate reading data from log files
    // $demo = new SocialNetworkDemoLogGenerator($this->members,$m);
  }

  private function union($a,$b)
  {
    $aPID = $this->members[$a];
    $bPID = $this->members[$b];
    if ($this->size[$aPID] <= $this->size[$bPID])
    {
      $this->members[$aPID] = $this->root($bPID);
      $this->size[$aPID] += $this->size[$bPID];
    }
    else
    {
      $this->members[$bPID] = $this->root($aPID);
      $this->size[$bPID] += $this->size[$aPID];
    }
  }

  private function root($memberID)
  {
    // $size = 0;
    while ($this->members[$memberID] != $memberID) {
      $memberID = $this->members[$memberID];
      // $size++;
    }
    // $this->size[$memberID] = $size;
    return $memberID;
  }

  // private function getSize($memberID)
  // {
  //   return isset($this->size[$memberID]) ? $this->size[$memberID] : 1;
  // }

  ## helper methods
  public function setDefaultSize()
  {
    foreach ($this->members as $key => $value) {
      $this->size[$key] = 1;
    }
  }

  ## demonstration methods
  private function rootLog($memberID)
  {
    echo "getRootOf {$memberID} ";
    // $size = 0;
    while ($this->members[$memberID] != $memberID) {
      $memberID = $this->members[$memberID];
      // $size++;
    }
    echo $memberID."\n";
    // $this->size[$memberID] = $size;
  }
}





$x = New SocialNetworkConnectivity(10,2);
// var_dump($x->members);





/*
  just to make sure that demo data are clean and realistic
 */
class SocialNetworkDemoLogGenerator
{
  public $friendshipsLogs = [];
  public $friendship = [];

  function __construct($members,$max)
  {
    for ($i=0; $i < $max;)
    {
      $member = array_rand($members);
      $will_add = array_rand($members);
      if (!isset($this->friendship[$member]))
      {
        $this->friendship[$member] = [];
      }
      if (!in_array($will_add,$this->friendship[$member]))
      {
        $this->friendship[$member][] = $will_add;
        // just similar to real time stamp
        $time = rand(1507000000,1507999900);
        $this->friendshipsLogs[] = [$time,$member,$will_add];
        $i++;
      }
    }
    var_dump($this->friendshipsLogs);
  }
}