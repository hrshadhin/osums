<?php
namespace App\Serializers;
use League\Fractal\Serializer\ArraySerializer;
class MySerializer extends ArraySerializer
{
	/**
	 * Serialize a collection
	 *
	 * @param  string  $resourceKey
	 * @param  array  $data
	 * @return array
	 **/
	public function collection($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}
	/**
	 * Serialize an item
	 *
	 * @param  string  $resourceKey
	 * @param  array  $data
	 * @return array
	 **/
	public function item($resourceKey, array $data)
	{
		return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
	}

}
