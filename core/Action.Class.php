<?php
class Action extends Base {
	static private $template;

	// ������ģ����չ�����Ĺ���
	public function __call($method, $params) {
		switch (explode('_', $method, 2)[0]) {
			case 'tpl':
				// ʹ��ģ�����еķ���
				$tpl_method = substr($method, 4);
				if (!is_object(self::$template)) {
					// ����SMARTYģ���ӿ��
					require_once leapJoin(__DIR__, DS, 'template', DS, 'Smarty.class.php');
					// ��ʼ��SMARTYģ��
					self::$template = new Smarty;
					// ģ���ļ���
					self::$template->setTemplateDir(leapJoin(APP_ABS_PATH, DS, APP_NAME, DS, 'templates'));
					// ģ������ļ���
					self::$template->setCompileDir(leapJoin(APP_ABS_PATH, DS, APP_NAME, DS, 'templates_c'));
					// ģ��CACHE�ļ���
					self::$template->setCacheDir(leapJoin(APP_ABS_PATH, DS, APP_NAME, DS, 'caches'));
					// ģ�����ұ߽�
					self::$template->setLeftDelimiter("<{");
					self::$template->setRightDelimiter("}>");
				}
				// ����ģ�巽��
				call_user_func_array(array(self::$template, $tpl_method), $params);
				break;
			default:
				die('method not found');
				break;
		}
	}

	// ҳ����ת
	static protected function redirect($url = '') {
		$url = $url == '' ? filter_input(INPUT_SERVER, 'HTTP_REFERER') : $url;
		header(leapJoin('Location: ', $url));
		exit;
	}
}
