<?php 
    $card_id = isset($args['card_id']) ? esc_attr($args['card_id']) : '';
    $card_title = isset($args['card_title']) ? esc_html($args['card_title']) : 'Default Title';
    $card_number = isset($args['card_number']) ? esc_attr($args['card_number']) : '0';
    $card_type = isset($args['card_type']) ? esc_html($args['card_type']) : 'Cloud'; // Default to Cloud
    $row_id = isset($args['row_id']) ? esc_attr($args['row_id']) : $card_id; // Ensure row ID is set correctly
?>

<div class="card" draggable="true" data-type="<?php echo $card_type; ?>" data-card-id="<?php echo $card_id; ?>">
    <h3 class="card-title"><?php echo $card_title; ?></h3>

    <!-- Show only for Cloud & Decentralized -->
    <?php if ($card_type !== 'On Prem') : ?>
        <p class="card-provider">Provider: None</p>
        <p class="card-text">Number: <?php echo $card_number; ?> TB</p>
    <?php else: ?>
        <p class="card-text">Number of Servers: 0</p>
    <?php endif; ?>

    <p class="card-cost">Total Cost: $0</p>
    <button class="btn btn-primary btn-edit-card" data-card-id="<?php echo $card_id; ?>">Edit</button>
</div>