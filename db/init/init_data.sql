-- buyers
INSERT INTO buyers
    VALUES(1, 'user')
  , VALUES(2, 'admin');

-- jumps
INSERT INTO jumps(release_day, price, combined_issue)
    VALUES(1, '2017-10-23', 260, 0)
  , VALUES(2, '2017-10-30', 260, 0)
  , VALUES(3, '2017-11-06', 260, 0);

-- buyer_jump
INSERT INTO buyer_jump
    VALUES(1, 1, 1, 1)
  , VALUES(2, 2, 2, 1)
  , VALUES(3, 1, 3, 0);
