-- buyers
INSERT INTO buyers(id, name) VALUES
    (1, 'user'),
    (2, 'admin');

-- jumps
INSERT INTO jumps(id, release_day, price, combined_issue) VALUES
    (1, '2017-10-23', 260, 0),
    (2, '2017-10-30', 260, 0),
    (3, '2017-11-06', 260, 0);

-- buyer_jump
INSERT INTO buyer_jump(id, buyer_id, jump_id, bought) VALUES
    (1, 1, 1, 1),
    (2, 2, 2, 1),
    (3, 1, 3, 0);
