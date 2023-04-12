<?php

namespace phuongdev89\base\helpers;

use yii\web\JsExpression;

/**
 * Class HtmlHelper
 * @package common\helpers
 */
class HtmlHelper {

	/**
	 * @param $data
	 * @param $url
	 *
	 * @return array
	 */
	public static function select2AjaxOption($data, $url): array
    {
		return [
			'data'          => $data,
			'pluginOptions' => [
				'allowClear'         => true,
				'minimumInputLength' => 3,
				'language'           => [
					'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
				],
				'ajax'               => [
					'url'      => $url,
					'dataType' => 'json',
					'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
				],
				'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
				'templateResult'     => new JsExpression('function(result) { return result.text; }'),
				'templateSelection'  => new JsExpression('function (result) { return result.text; }'),
			],
		];
	}
}
