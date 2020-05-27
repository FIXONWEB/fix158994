<?php
/**
 * Plugin Name:     fix158994
 * Plugin URI:      https://github.com/fixonweb/fix158994
 * Description:     Sniper shortcode para the event calendar
 * Author:          FIXONWEB
 * Author URI:      https://github.com/fixonweb
 * Text Domain:     fix158994
 * Domain Path:     /languages
 * Version:         0.1.2
 *
 * @package         Fix158994
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_shortcode("fix158994", "fix158994");
function fix158994($atts, $content = null) {
	ob_start();
	?>
	<style type="text/css" media="screen">
		.fix158994 {
			color: black;
		}
		.fix158994 a {
			color: black;
		}

		.fix158994 .fix_title {
			font-size: 110%;
			font-weight: bold;
			line-height: 1;
		}
	</style>
	<div class="fix158994">
		<div class="box">
			<div class="fix_title">
				<a href="#" title="">Workshop: Desafios das Movimentações internas dos servidores</a>
			</div>
			<div class="fix_metas">
				Data: 16/06/2020 | Carga horária: 2 h
			</div>
			<div class="fix_saiba_mais">
				<a href="#" title="">&lt; Saiba mais &gt;</a>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}




















add_shortcode("fix158994_list", "fix158994_list");
function fix158994_list($atts, $content = null) {
    extract(shortcode_atts(array(
        "busca_tipo" => 'depois',//'depois'
        "categoria" => '',
        "style_box" => 'margin:10px;',
        "style_title" => 'line-height:1;margin: unset;',
        "limit" 	=> '3'
    ), $atts));

    if($busca_tipo=='antes') {
  		$busca_operador = "<";
  		$sql_order = " DESC ";
  	}
  	if($busca_tipo=='depois') {
  		$busca_operador = ">";
  		$sql_order = " ASC ";
  	}

	$categoria_left_join = '';
	$categoria_where = '';
	$agora = date('Y-m-d H:i:s', current_time('timestamp'));
	// $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;//;;//( get_query_var('limit') ) ? get_query_var('limit') : 10;
	$start = isset($_GET['start']) ? $_GET['start'] : '0';
    if ($paged) {
        $start = (int)(($paged * $limit) - $limit);
    }


	$sql_busca = '';
	if ($busca) $sql_busca = " AND " . $GLOBALS['wpdb']->prefix . "posts.post_title LIKE '%" . $busca . "%'";

    $sql = "
	SELECT
		" . $GLOBALS['wpdb']->prefix . "posts.ID,
		" . $GLOBALS['wpdb']->prefix . "posts.post_title,
		" . $GLOBALS['wpdb']->prefix . "posts.guid,
		" . $GLOBALS['wpdb']->prefix . "posts.post_content,
		meta_ini_date.meta_value as ini_date,
		meta_end_date.meta_value as end_date,
		meta_carga_horaria.meta_value as carga_horaria,
		meta_eventallday.meta_value as eventallday

	FROM " . $GLOBALS['wpdb']->prefix . "posts
	LEFT JOIN " . $GLOBALS['wpdb']->prefix . "postmeta AS meta_ini_date ON " . $GLOBALS['wpdb']->prefix . "posts.ID = meta_ini_date.post_id AND meta_ini_date.meta_key='_EventStartDate'
	LEFT JOIN " . $GLOBALS['wpdb']->prefix . "postmeta AS meta_end_date ON " . $GLOBALS['wpdb']->prefix . "posts.ID = meta_end_date.post_id AND meta_end_date.meta_key='_EventEndDate'
	LEFT JOIN " . $GLOBALS['wpdb']->prefix . "postmeta AS meta_carga_horaria ON " . $GLOBALS['wpdb']->prefix . "posts.ID = meta_carga_horaria.post_id AND meta_carga_horaria.meta_key='carga_horaria'
	LEFT JOIN " . $GLOBALS['wpdb']->prefix . "postmeta AS meta_eventallday ON " . $GLOBALS['wpdb']->prefix . "posts.ID = meta_eventallday.post_id AND meta_eventallday.meta_key='_EventAllDay'
	WHERE
		".$GLOBALS['wpdb']->prefix."posts.post_status = 'publish'
		AND ".$GLOBALS['wpdb']->prefix."posts.post_type = 'tribe_events'
		AND meta_ini_date.meta_value " . $busca_operador . " '" . $agora . "'
	ORDER BY meta_ini_date.meta_value " . $sql_order . "
	limit " . $start . "," . $limit . "
	";
    global $charset_collate;
    global $wpdb;
    $eventos = $wpdb->get_results($sql);

    // echo $sql;


/*
eventos.meta_value AS eventos
		LEFT JOIN " . $GLOBALS['wpdb']->prefix . "postmeta AS eventos ON " . $GLOBALS['wpdb']->prefix . "posts.ID = eventos.post_id
		" . $categoria_left_join . "
		AND eventos.meta_key='_EventEndDate'
	WHERE
		" . $GLOBALS['wpdb']->prefix . "posts.post_status = 'publish'
		AND " . $GLOBALS['wpdb']->prefix . "posts.post_type = 'tribe_events'
		" . $categoria_where . "
		AND eventos.meta_value " . $busca_operador . " '" . $agora . "'
		" . $sql_busca . "
	ORDER BY eventos.meta_value " . $sql_order . "
	limit " . $start . "," . $limit . "
*/
	ob_start();
	?>
	<style type="text/css" media="screen">
		.fix158994__list {
			color: black;
		}
		.fix158994__list a {
			color: black;
		}

		.fix158994__list .fix__title {
			font-size: 110%;
			font-weight: bold;
			line-height: 1;
		}
	</style>
	<div class="fix158994_list">
		<?php foreach ($eventos as $evento) { ?>

			<?php 

				$data_ini_e = explode("-", $evento->ini_date);
				$data_ini_ano = $data_ini_e[0];
				$data_ini_mes = $data_ini_e[1];
				$data_ini_dia = substr($data_ini_e[2], 0, 2);
				$data_ini_hora = substr($data_ini_e[2], 3, 5);
				// echo '<pre>';
				// print_r($data_ini_e);
				// echo '</pre>';

				$data_end_e = explode("-", $evento->end_date);
				$data_end_ano = $data_end_e[0];
				$data_end_mes = $data_end_e[1];
				$data_end_dia = substr($data_end_e[2], 0, 2);
				$data_end_hora = substr($data_end_e[2], 3, 5);
				// echo '<pre>';
				// print_r($data_end_e);
				// echo '</pre>';
			?>
		<div class="box" style="<?php echo $style_box ?>">
			<h3 style="<?php echo $style_title ?>"><?php echo $evento->post_title ?></h3>
			<div class="fix_metas" style="<?php echo $fix_metas ?>">
				Data: <?php echo $data_ini_dia ?>/<?php echo $data_ini_mes ?>/<?php echo $data_ini_ano ?>
				
				<?php if(!$evento->eventallday) { ?> 
				 : <?php echo $data_ini_hora ?> 
				<?php } ?>

				<?php if($evento->carga_horaria) { ?>
				| Carga horária: <?php echo $evento->carga_horaria ?>
				<?php } ?>

			</div>
			<div class="fix_saiba_mais">
				<a href="<?php echo $evento->guid ?>" title="">&lt; Saiba mais &gt;</a>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php
//allDayCheckbox
    // echo '<pre>';
    // print_r($eventos);
    // echo '</pre>';

	return ob_get_clean();
}
