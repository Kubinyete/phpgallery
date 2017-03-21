<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página 404
 */

namespace App\Models;

use App\Models\Model;
use App\Views\NotFoundView;

class NotFoundModel extends Model {
	public function index() {
		return new NotFoundView();
	}
}

?>