<?php exit; ?>
1743836895
SELECT m.*, u.user_colour, g.group_colour, g.group_type FROM (phpbbyy_moderator_cache m) LEFT JOIN phpbbyy_users u ON (m.user_id = u.user_id) LEFT JOIN phpbbyy_groups g ON (m.group_id = g.group_id) WHERE m.display_on_index = 1
6
a:0:{}