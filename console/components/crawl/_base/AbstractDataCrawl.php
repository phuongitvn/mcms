<?php
abstract class AbstractDataCrawl
{
	public abstract function __construct($config);
	public abstract function getTitle();
}