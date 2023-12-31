<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Contentwarehouse;

<<<<<<< HEAD
class RepositoryWebrefDetailedMentionScores extends \Google\Model
{
=======
class RepositoryWebrefDetailedMentionScores extends \Google\Collection
{
  protected $collection_key = 'patternInfo';
  protected $patternInfoType = RepositoryWebrefPatternInfo::class;
  protected $patternInfoDataType = 'array';
  public $patternInfo;
  /**
   * @var float
   */
  public $posteriorForLearning;
>>>>>>> 1f8fa8284 (env)
  /**
   * @var float
   */
  public $resultEntityScore;

  /**
<<<<<<< HEAD
=======
   * @param RepositoryWebrefPatternInfo[]
   */
  public function setPatternInfo($patternInfo)
  {
    $this->patternInfo = $patternInfo;
  }
  /**
   * @return RepositoryWebrefPatternInfo[]
   */
  public function getPatternInfo()
  {
    return $this->patternInfo;
  }
  /**
   * @param float
   */
  public function setPosteriorForLearning($posteriorForLearning)
  {
    $this->posteriorForLearning = $posteriorForLearning;
  }
  /**
   * @return float
   */
  public function getPosteriorForLearning()
  {
    return $this->posteriorForLearning;
  }
  /**
>>>>>>> 1f8fa8284 (env)
   * @param float
   */
  public function setResultEntityScore($resultEntityScore)
  {
    $this->resultEntityScore = $resultEntityScore;
  }
  /**
   * @return float
   */
  public function getResultEntityScore()
  {
    return $this->resultEntityScore;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(RepositoryWebrefDetailedMentionScores::class, 'Google_Service_Contentwarehouse_RepositoryWebrefDetailedMentionScores');
