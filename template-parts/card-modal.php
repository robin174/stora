<?php
  $card_id = isset($args['card_id']) ? $args['card_id'] : '';
  $card_title = isset($args['card_title']) ? $args['card_title'] : "Card $card_id";
  $card_number = isset($args['card_number']) ? $args['card_number'] : "-";
?>

<div class="card" data-card-id="<?php echo esc_attr($card_id); ?>">
    <div class="card-body">
        <h5 class="card-title"><?php echo esc_html($card_title); ?></h5>
        <p class="card-text">Number: <?php echo esc_html($card_number); ?></p>
        <button class="btn btn-primary btn-edit-card">Edit</button> <!-- Remove onclick -->
    </div>
</div>