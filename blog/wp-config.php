<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/var/www/html/blog/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'blog');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'blog');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'aKjs92Xks');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|cmKG5$+ejy:mrWfQ/;LpsCr{uvWT XUV;}|HqfC>#{{sq;PEPyc;Re&hCr4GGLC');
define('SECURE_AUTH_KEY',  '0PD}_57e|-|+84Szi`EhxT3+(T+<s+HfF1qc|JZe+-B +YqY$]DYsKddURBI]2T,');
define('LOGGED_IN_KEY',    '1KiT[uoIL<9+1<lC^2U&r_|s3W9}/JD!$:.tB3699$n4O+3/KV0gLi^~q}@w-?NP');
define('NONCE_KEY',        'pqwqzi?cb;kQ:~A-^Vs}1OAiE3t8%5p_Y|vf+~.j+qwZI3e(!u|`.{~|FlAZ{+Ir');
define('AUTH_SALT',        '`{F T2L3(ea$D{--.E_=[V+J^i(`B*Y5~3~lGGc/`<Q($2F^X>U%=),.2pC#%8ol');
define('SECURE_AUTH_SALT', ':98i. ^!*5GWuCe+!+PIqs*6B9}Ch3zjct&kpjht2W$yfzFgyb|q]0Kl)R2e>Qm9');
define('LOGGED_IN_SALT',   '0(I-59M2,=+tE7t18S+-Q^H`?Z||T#JIWoQ{+Ca:v-3DPV2fmB>P&mvU50i}Q{Rk');
define('NONCE_SALT',       '/+PM6%+G#fo8|O>{#,KXJs!V$%<{.9JW~]O)J5$Jl0JN:{bmt d,]hq ^fb=0_LR');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
