// Создаем виджет BlogTool.ru
class btru_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Выбираем ID для своего виджета
'btru_widget',

// Название виджета, показано в консоли
__('BlogTool Widget', 'btru_widget_domain'),

// Описание виджета
array( 'description' => __( 'Простенький виджет для демонстрации BlogTool.ru', 'btru_widget_domain' ), )
);
}

// Создаем код для виджета -
// сначала небольшая идентификация
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// до и после идентификации переменных темой
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// Именно здесь записываем весь код и вывод данных
echo __( 'Hello, World! или привет Мир!', 'btru_widget_domain' );
echo $args['after_widget'];
}

// Закрываем код виджета
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Заголовок виджета', 'btru_widget_domain' );
}
// Для административной консоли
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}

// Обновление виджета
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Закрываем класс btru_widget

// Регистрируем и запускаем виджет
function btru_load_widget() {
	register_widget( 'btru_widget' );
}
add_action( 'widgets_init', 'btru_load_widget' );
