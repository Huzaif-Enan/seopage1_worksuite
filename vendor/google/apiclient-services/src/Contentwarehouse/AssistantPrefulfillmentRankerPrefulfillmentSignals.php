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

class AssistantPrefulfillmentRankerPrefulfillmentSignals extends \Google\Model
{
  /**
   * @var float
   */
  public $bindingSetAuis;
  /**
   * @var float
   */
  public $bindingSetPauis;
  public $calibratedParsingScore;
  /**
   * @var bool
   */
<<<<<<< HEAD
  public $deepMediaDominant;
  /**
   * @var bool
   */
=======
>>>>>>> 1f8fa8284 (env)
  public $dominant;
  /**
   * @var float
   */
  public $effectiveArgSpanLength;
<<<<<<< HEAD
  /**
   * @var bool
   */
  public $fulfillableDominantMedia;
=======
>>>>>>> 1f8fa8284 (env)
  public $groundabilityScore;
  protected $groundingProviderFeaturesType = AssistantGroundingRankerGroundingProviderFeatures::class;
  protected $groundingProviderFeaturesDataType = '';
  public $groundingProviderFeatures;
  /**
   * @var float
   */
  public $inQueryMaxEffectiveArgSpanLength;
  /**
   * @var string
   */
  public $intentName;
  public $intentNameAuisScore;
  public $intentNameAuisScoreExp;
  /**
   * @var bool
   */
  public $isFeasible;
  /**
   * @var int
   */
  public $kscorerRank;
<<<<<<< HEAD
  protected $laaFeaturesType = AssistantGroundingRankerLaaFeatures::class;
  protected $laaFeaturesDataType = '';
  public $laaFeatures;
=======
>>>>>>> 1f8fa8284 (env)
  /**
   * @var bool
   */
  public $maskCandidateLevelFeatures;
  public $maxHgrScoreAcrossBindingSets;
  /**
   * @var float
   */
  public $numAlternativeHypothesis;
  public $numConstraints;
  public $numConstraintsSatisfied;
  public $numGroundableArgs;
  public $numGroundedArgs;
  public $numVariables;
  public $numVariablesGrounded;
  public $pq2tVsAssistantIbstCosine;
  public $pq2tVsIbstCosine;
  /**
   * @var float
   */
  public $predictedIntentConfidence;
  /**
   * @var string
   */
  public $searchDispatch;
  /**
   * @var float
   */
  public $topHypothesisConfidence;
  /**
   * @var float
   */
  public $verticalConfidenceScore;

  /**
   * @param float
   */
  public function setBindingSetAuis($bindingSetAuis)
  {
    $this->bindingSetAuis = $bindingSetAuis;
  }
  /**
   * @return float
   */
  public function getBindingSetAuis()
  {
    return $this->bindingSetAuis;
  }
  /**
   * @param float
   */
  public function setBindingSetPauis($bindingSetPauis)
  {
    $this->bindingSetPauis = $bindingSetPauis;
  }
  /**
   * @return float
   */
  public function getBindingSetPauis()
  {
    return $this->bindingSetPauis;
  }
  public function setCalibratedParsingScore($calibratedParsingScore)
  {
    $this->calibratedParsingScore = $calibratedParsingScore;
  }
  public function getCalibratedParsingScore()
  {
    return $this->calibratedParsingScore;
  }
  /**
   * @param bool
   */
<<<<<<< HEAD
  public function setDeepMediaDominant($deepMediaDominant)
  {
    $this->deepMediaDominant = $deepMediaDominant;
  }
  /**
   * @return bool
   */
  public function getDeepMediaDominant()
  {
    return $this->deepMediaDominant;
  }
  /**
   * @param bool
   */
=======
>>>>>>> 1f8fa8284 (env)
  public function setDominant($dominant)
  {
    $this->dominant = $dominant;
  }
  /**
   * @return bool
   */
  public function getDominant()
  {
    return $this->dominant;
  }
  /**
   * @param float
   */
  public function setEffectiveArgSpanLength($effectiveArgSpanLength)
  {
    $this->effectiveArgSpanLength = $effectiveArgSpanLength;
  }
  /**
   * @return float
   */
  public function getEffectiveArgSpanLength()
  {
    return $this->effectiveArgSpanLength;
  }
<<<<<<< HEAD
  /**
   * @param bool
   */
  public function setFulfillableDominantMedia($fulfillableDominantMedia)
  {
    $this->fulfillableDominantMedia = $fulfillableDominantMedia;
  }
  /**
   * @return bool
   */
  public function getFulfillableDominantMedia()
  {
    return $this->fulfillableDominantMedia;
  }
=======
>>>>>>> 1f8fa8284 (env)
  public function setGroundabilityScore($groundabilityScore)
  {
    $this->groundabilityScore = $groundabilityScore;
  }
  public function getGroundabilityScore()
  {
    return $this->groundabilityScore;
  }
  /**
   * @param AssistantGroundingRankerGroundingProviderFeatures
   */
  public function setGroundingProviderFeatures(AssistantGroundingRankerGroundingProviderFeatures $groundingProviderFeatures)
  {
    $this->groundingProviderFeatures = $groundingProviderFeatures;
  }
  /**
   * @return AssistantGroundingRankerGroundingProviderFeatures
   */
  public function getGroundingProviderFeatures()
  {
    return $this->groundingProviderFeatures;
  }
  /**
   * @param float
   */
  public function setInQueryMaxEffectiveArgSpanLength($inQueryMaxEffectiveArgSpanLength)
  {
    $this->inQueryMaxEffectiveArgSpanLength = $inQueryMaxEffectiveArgSpanLength;
  }
  /**
   * @return float
   */
  public function getInQueryMaxEffectiveArgSpanLength()
  {
    return $this->inQueryMaxEffectiveArgSpanLength;
  }
  /**
   * @param string
   */
  public function setIntentName($intentName)
  {
    $this->intentName = $intentName;
  }
  /**
   * @return string
   */
  public function getIntentName()
  {
    return $this->intentName;
  }
  public function setIntentNameAuisScore($intentNameAuisScore)
  {
    $this->intentNameAuisScore = $intentNameAuisScore;
  }
  public function getIntentNameAuisScore()
  {
    return $this->intentNameAuisScore;
  }
  public function setIntentNameAuisScoreExp($intentNameAuisScoreExp)
  {
    $this->intentNameAuisScoreExp = $intentNameAuisScoreExp;
  }
  public function getIntentNameAuisScoreExp()
  {
    return $this->intentNameAuisScoreExp;
  }
  /**
   * @param bool
   */
  public function setIsFeasible($isFeasible)
  {
    $this->isFeasible = $isFeasible;
  }
  /**
   * @return bool
   */
  public function getIsFeasible()
  {
    return $this->isFeasible;
  }
  /**
   * @param int
   */
  public function setKscorerRank($kscorerRank)
  {
    $this->kscorerRank = $kscorerRank;
  }
  /**
   * @return int
   */
  public function getKscorerRank()
  {
    return $this->kscorerRank;
  }
  /**
<<<<<<< HEAD
   * @param AssistantGroundingRankerLaaFeatures
   */
  public function setLaaFeatures(AssistantGroundingRankerLaaFeatures $laaFeatures)
  {
    $this->laaFeatures = $laaFeatures;
  }
  /**
   * @return AssistantGroundingRankerLaaFeatures
   */
  public function getLaaFeatures()
  {
    return $this->laaFeatures;
  }
  /**
=======
>>>>>>> 1f8fa8284 (env)
   * @param bool
   */
  public function setMaskCandidateLevelFeatures($maskCandidateLevelFeatures)
  {
    $this->maskCandidateLevelFeatures = $maskCandidateLevelFeatures;
  }
  /**
   * @return bool
   */
  public function getMaskCandidateLevelFeatures()
  {
    return $this->maskCandidateLevelFeatures;
  }
  public function setMaxHgrScoreAcrossBindingSets($maxHgrScoreAcrossBindingSets)
  {
    $this->maxHgrScoreAcrossBindingSets = $maxHgrScoreAcrossBindingSets;
  }
  public function getMaxHgrScoreAcrossBindingSets()
  {
    return $this->maxHgrScoreAcrossBindingSets;
  }
  /**
   * @param float
   */
  public function setNumAlternativeHypothesis($numAlternativeHypothesis)
  {
    $this->numAlternativeHypothesis = $numAlternativeHypothesis;
  }
  /**
   * @return float
   */
  public function getNumAlternativeHypothesis()
  {
    return $this->numAlternativeHypothesis;
  }
  public function setNumConstraints($numConstraints)
  {
    $this->numConstraints = $numConstraints;
  }
  public function getNumConstraints()
  {
    return $this->numConstraints;
  }
  public function setNumConstraintsSatisfied($numConstraintsSatisfied)
  {
    $this->numConstraintsSatisfied = $numConstraintsSatisfied;
  }
  public function getNumConstraintsSatisfied()
  {
    return $this->numConstraintsSatisfied;
  }
  public function setNumGroundableArgs($numGroundableArgs)
  {
    $this->numGroundableArgs = $numGroundableArgs;
  }
  public function getNumGroundableArgs()
  {
    return $this->numGroundableArgs;
  }
  public function setNumGroundedArgs($numGroundedArgs)
  {
    $this->numGroundedArgs = $numGroundedArgs;
  }
  public function getNumGroundedArgs()
  {
    return $this->numGroundedArgs;
  }
  public function setNumVariables($numVariables)
  {
    $this->numVariables = $numVariables;
  }
  public function getNumVariables()
  {
    return $this->numVariables;
  }
  public function setNumVariablesGrounded($numVariablesGrounded)
  {
    $this->numVariablesGrounded = $numVariablesGrounded;
  }
  public function getNumVariablesGrounded()
  {
    return $this->numVariablesGrounded;
  }
  public function setPq2tVsAssistantIbstCosine($pq2tVsAssistantIbstCosine)
  {
    $this->pq2tVsAssistantIbstCosine = $pq2tVsAssistantIbstCosine;
  }
  public function getPq2tVsAssistantIbstCosine()
  {
    return $this->pq2tVsAssistantIbstCosine;
  }
  public function setPq2tVsIbstCosine($pq2tVsIbstCosine)
  {
    $this->pq2tVsIbstCosine = $pq2tVsIbstCosine;
  }
  public function getPq2tVsIbstCosine()
  {
    return $this->pq2tVsIbstCosine;
  }
  /**
   * @param float
   */
  public function setPredictedIntentConfidence($predictedIntentConfidence)
  {
    $this->predictedIntentConfidence = $predictedIntentConfidence;
  }
  /**
   * @return float
   */
  public function getPredictedIntentConfidence()
  {
    return $this->predictedIntentConfidence;
  }
  /**
   * @param string
   */
  public function setSearchDispatch($searchDispatch)
  {
    $this->searchDispatch = $searchDispatch;
  }
  /**
   * @return string
   */
  public function getSearchDispatch()
  {
    return $this->searchDispatch;
  }
  /**
   * @param float
   */
  public function setTopHypothesisConfidence($topHypothesisConfidence)
  {
    $this->topHypothesisConfidence = $topHypothesisConfidence;
  }
  /**
   * @return float
   */
  public function getTopHypothesisConfidence()
  {
    return $this->topHypothesisConfidence;
  }
  /**
   * @param float
   */
  public function setVerticalConfidenceScore($verticalConfidenceScore)
  {
    $this->verticalConfidenceScore = $verticalConfidenceScore;
  }
  /**
   * @return float
   */
  public function getVerticalConfidenceScore()
  {
    return $this->verticalConfidenceScore;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AssistantPrefulfillmentRankerPrefulfillmentSignals::class, 'Google_Service_Contentwarehouse_AssistantPrefulfillmentRankerPrefulfillmentSignals');
