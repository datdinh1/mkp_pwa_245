<?php

namespace Wiki\StoreApi\Api\Data;

interface RuleInterface
{
  /**
   * Constants for keys of data array
   */
  const IMAGE                   = 'image';


  /**
   * Get image
   *
   * @return string
   */
  public function getImage();

  /**
   * Set image
   *
   * @param $image
   * @return RuleInterface
   */
  public function setImage($image);
}
