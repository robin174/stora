<?php
  $card_id = isset($args['card_id']) ? $args['card_id'] : '';
  $card_title = isset($args['card_title']) ? $args['card_title'] : "Card $card_id";
  $card_number = isset($args['card_number']) ? $args['card_number'] : "-";
?>

<div class="card" data-card-id="<?php echo esc_attr($card_id); ?>">
    <div class="card-body">
        <h5 class="card-title" id="card-title-<?php echo esc_attr($card_id); ?>">
            <?php echo esc_html($card_title); ?>
        </h5>
        <p class="card-text" id="card-number-<?php echo esc_attr($card_id); ?>">
            Number: <?php echo esc_html($card_number); ?>
        </p>
        <button class="btn btn-primary" onclick="openModal(<?php echo esc_attr($card_id); ?>)">Edit</button>
    </div>
</div>