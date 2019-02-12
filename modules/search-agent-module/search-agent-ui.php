<div id="search-agent-module" class="hidden">
    <link rel="stylesheet" href="/modules/search-agent-module/search-agent-style.css" />
    <script src="/modules/search-agent-module/search-agent-script.js"></script>
    <div id="search-agent-window">
        <div id="current-agent-list-container">
            <ol id="agent-list">
                <?php
                $agent_list = get_currently_serving_agent_list($today);
                $index_seq = [7,8,9,1,2,3,4,5,6];
                foreach ($index_seq as $index) {
                    $agent = $agent_list[$index - 1];
                ?>
                <li class="agent-item" data-agent-id="<?php echo $agent['id']; ?>" data-agent-name="<?php echo $agent['name']; ?>">
                    <div class="call">
                        <?php echo get_agent_call($agent['roll'], true); ?>
                    </div>
                    <div class="name">
                        <?php echo $agent['name']; ?>
                    </div>
                </li>
                <?php
                }
                ?>
            </ol>
        </div>
    </div>
    <div id="search-agent-bg">

    </div>
</div>
