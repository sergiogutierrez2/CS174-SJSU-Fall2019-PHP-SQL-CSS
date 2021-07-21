<?php
//RC4 function start
function rc4($key_str, $data_str)
{
    $kunci = array();
    $data = array();
 
    for ($a = 0; $a < strlen($key_str); $a++) 
    {
        $kunci[] = ord($key_str{$a});//convert each string into ASCII
    }
    for ($b = 0; $b < strlen($data_str); $b++) 
    {
        $data[] = ord($data_str{$b});
    }
    //make a 256bit key
    for ($knc = 0; $knc < 256; $knc++) 
    {
        $state[] = $knc;//make an array of keys up to 256
    }
  
    $len = count($kunci);
    $index1 = $index2 = 0; 
    for ($hitung = 0; $hitung < 256; $hitung++) 
    {
        $index2 = ($kunci[$index1] + $state[$hitung] + $index2) % 256;
        $tmp = $state[$hitung];
        $state[$hitung] = $state[$index2];
        $state[$index2] = $tmp;
        $index1 = ($index1 + 1) % $len;
    }
    //encryption with rc4
    $len = count($data);
    $ix = $iy = 0; 
    for ($hitung1 = 0; $hitung1 < $len; $hitung1++) 
    {
        $ix = ($ix + 1) % 256;
        $iy = ($state[$ix] + $iy) % 256;
        $tmp = $state[$ix];
        $state[$ix] = $state[$iy]; 
        $state[$iy] = $tmp;
        $data[$hitung1] ^= $state[($state[$ix] + $state[$iy]) % 256];
    }
    //convert to string
    $data_str = "";
    for ($i = 0; $i < $len; $i++) 
    {
        $data_str .= chr($data[$i]);
    }
    return $data_str;
}
//RC4 function end

//SimpleSubstitution start
class simpleSubstitution
{
    function cipher($ch, $key)
    {
        if (!ctype_alpha($ch))
            return $ch;
        $var = ord(ctype_upper($ch) ? 'A' : 'a');
        return chr(fmod(((ord($ch) + $key) - $var), 26) + $var);
    }
    function encrypt($input, $key)
    {
        $space = " "; 
        $n = str_split($input);
        foreach ($n as $ch) {
            $space .= self::cipher($ch, $key); 
        }
        return $space;
    }
    function decrypt($input, $key)
    {
        return self::encrypt($input, 26 - $key);
    }
}
//Simple Substitution end


//DOUBLE TRANSPOSITION CODE START
//DOUBLE TRANSPOSITION CODE END

//DES CIPHER CODE START

function DES($key_str, $data_str){

  // turn plaintext into array of 64 bit blocks (8 characters 1 byte each, or each block an array of 8 bytes)
  $plainblocks = array();
  for($i = 0; $i < strlen($data_str); $i += 8)
    for($j = 0; $j < 8; $j++)
      $plainblocks[$i][$j] = 0;   // initialize each byte, 8 per block
  for($i = 0; $i < strlen($data_str); $i++)
    $plainblocks[intdiv($i, 8)][$i % 8] = ord($data_str{$i});

  // hold another array for ciphertext 64bit blocks
  $cipherblocks = array();

  // calculate 16 keys
  $keys = keys($key_str);

  // encrypt
  for($block = 0; $block < count($plainblocks); $block++){  // for each 64 bit block
    for($round = 0; $round < 16; $round++){         // for each round
      // hold old block 
      $oldBlock = $plainblocks[$block];
      // create new block based on old block
      $newBlock = array();

      // 32bit left half new block is just right half old block
      // 32bit right half new block is left half old block XOR with round function of right half old block and a key
      for($i = 0; $i < 4; $i++)
        $newBlock[] = $oldBlock[$i + 4];
      for($i = 0; $i < 4; $i++)
        $newBlock[] = $oldBlock[$i] ^ roundFunction($oldBlock[$i + 4], $keys[$round]);
      
      $cipherblocks[] = $newblock;
    }
  }

  // turn array of cipher 64bit blocks into ciphertext
  foreach($cipherblocks as $block)
    foreach($block as $byte)
      $ciphertext .= chr($byte);

  // return ciphertext
  return $ciphertext;
}

function roundFunction($r, $ki){  // r array of 4 bytes, $ki array of 6 bytes
  // expand 32 bit R to 48 bits
  $expand = expand($r);

  // R XOR Ki
  $xor = array(); // 6 bytes
  for($i = 0; $i < 6; $i++)
    $xor[] = $expand[$i] ^ $ki[$i];

  // shrink 48 bits to 32 bits with 8 S Boxes
  $shrink = sBoxes($xor);

  // shuffle with P box
  $shuffle = pBox($shrink);

  // return result of P box
  return $shuffle;
}

function keys($key){  // array of 8 bytes
  $pc1Left = array();   // array of 4 7bits
  $pc1Right = array();

  // 56 48 40 32 24 16 08
  $pc1Left[] = mergeBits7(getBit8($key[7], 0), getBit8($key[6], 0), getBit8($key[5], 0), getBit8($key[4], 0),
                          getBit8($key[3], 0), getBit8($key[2], 0), getBit8($key[1], 0));

  // 00 57 49 41 33 25 17
  $pc1Left[] = mergeBits7(getBit8($key[0], 0), getBit8($key[7], 1), getBit8($key[6], 1), getBit8($key[5], 1),
                          getBit8($key[4], 1), getBit8($key[3], 1), getBit8($key[2], 1));

  // 09 01 58 50 42 34 26
  $pc1Left[] = mergeBits7(getBit8($key[1], 1), getBit8($key[0], 1), getBit8($key[7], 2), getBit8($key[6], 2),
                          getBit8($key[5], 2), getBit8($key[4], 2), getBit8($key[3], 2));

  // 18 10 02 59 51 43 35
  $pc1Left[] = mergeBits7(getBit8($key[2], 2), getBit8($key[1], 2), getBit8($key[0], 2), getBit8($key[7], 3),
                          getBit8($key[6], 3), getBit8($key[5], 3), getBit8($key[4], 3));

  // 62 54 46 38 30 22 14
  $pc1Right[] = mergeBits7(getBit8($key[7], 6), getBit8($key[6], 6), getBit8($key[5], 6), getBit8($key[4], 6),
                          getBit8($key[3], 6), getBit8($key[2], 6), getBit8($key[1], 6));
  // 06 61 53 45 37 29 21
  $pc1Right[] = mergeBits7(getBit8($key[0], 6), getBit8($key[7], 5), getBit8($key[6], 5), getBit8($key[5], 5),
                          getBit8($key[4], 5), getBit8($key[3], 5), getBit8($key[2], 5));
  // 13 05 60 52 44 36 28
  $pc1Right[] = mergeBits7(getBit8($key[1], 5), getBit8($key[0], 5), getBit8($key[7], 4), getBit8($key[6], 4),
                          getBit8($key[5], 4), getBit8($key[4], 4), getBit8($key[3], 4));
  // 20 12 04 27 19 11 03
  $pc1Right[] = mergeBits7(getBit8($key[2], 4), getBit8($key[1], 4), getBit8($key[0], 4), getBit8($key[3], 3),
                          getBit8($key[2], 3), getBit8($key[1], 3), getBit8($key[0], 3));

  // shift halves
  $c = array();
  $d = array();

  $c[] = shiftLeft($pc1Left, 1);
  $c[] = shiftLeft($c[0], 1);
  $c[] = shiftLeft($c[1], 2);
  $c[] = shiftLeft($c[2], 2);
  $c[] = shiftLeft($c[3], 2);
  $c[] = shiftLeft($c[4], 2);
  $c[] = shiftLeft($c[5], 2);
  $c[] = shiftLeft($c[6], 2);
  $c[] = shiftLeft($c[7], 1);
  $c[] = shiftLeft($c[8], 2);
  $c[] = shiftLeft($c[9], 2);
  $c[] = shiftLeft($c[10], 2);
  $c[] = shiftLeft($c[11], 2);
  $c[] = shiftLeft($c[12], 2);
  $c[] = shiftLeft($c[13], 2);
  $c[] = shiftLeft($c[14], 1);

  $d[] = shiftLeft($pc1Right, 1);
  $d[] = shiftLeft($d[0], 1);
  $d[] = shiftLeft($d[1], 2);
  $d[] = shiftLeft($d[2], 2);
  $d[] = shiftLeft($d[3], 2);
  $d[] = shiftLeft($d[4], 2);
  $d[] = shiftLeft($d[5], 2);
  $d[] = shiftLeft($d[6], 2);
  $d[] = shiftLeft($d[7], 1);
  $d[] = shiftLeft($d[8], 2);
  $d[] = shiftLeft($d[9], 2);
  $d[] = shiftLeft($d[10], 2);
  $d[] = shiftLeft($d[11], 2);
  $d[] = shiftLeft($d[12], 2);
  $d[] = shiftLeft($d[13], 2);
  $d[] = shiftLeft($d[14], 1);

  // merge halves
  $cd = array();
  for($i = 0; $i < 16; $i++)
    $cd[] = mergeBits56($c[$i], $d[$i]);  // 28 bytes each half

  // form 16 keys from c1d1, c2d2, etc.
  $keys = array();

  for($i = 0; $i < 16; $i++){

    // 13 16 10 23 00 04 02 27
    $keys[$i][] =  mergeBits8(getBit8($cd[1],5), getBit8($cd[2],0), getBit8($cd[1],2), getBit8($cd[2],7),
                              getBit8($cd[0],0), getBit8($cd[0],4), getBit8($cd[0],2), getBit8($cd[3],3));

    // 14 05 20 09 22 18 11 03
    $keys[$i][] =  mergeBits8(getBit8($cd[1],6), getBit8($cd[0],5), getBit8($cd[2],4), getBit8($cd[1],1),
                              getBit8($cd[2],6), getBit8($cd[2],2), getBit8($cd[1],3), getBit8($cd[0],3));

    // 25 07 15 06 26 19 12 01
    $keys[$i][] =  mergeBits8(getBit8($cd[3],1), getBit8($cd[0],7), getBit8($cd[1],7), getBit8($cd[0],6),
                              getBit8($cd[3],2), getBit8($cd[2],3), getBit8($cd[1],4), getBit8($cd[0],1));

    // 40 51 30 36 46 54 29 39
    $keys[$i][] =  mergeBits8(getBit8($cd[5],0), getBit8($cd[6],3), getBit8($cd[3],6), getBit8($cd[4],4),
                              getBit8($cd[5],6), getBit8($cd[6],6), getBit8($cd[3],5), getBit8($cd[4],7));

    // 50 44 32 47 43 48 38 55
    $keys[$i][] =  mergeBits8(getBit8($cd[6],2), getBit8($cd[5],4), getBit8($cd[4],0), getBit8($cd[5],7),
                              getBit8($cd[5],3), getBit8($cd[6],0), getBit8($cd[4],6), getBit8($cd[6],7));

    // 33 52 45 41 49 35 28 31
    $keys[$i][] =  mergeBits8(getBit8($cd[4],1), getBit8($cd[6],4), getBit8($cd[5],5), getBit8($cd[5],1),
                              getBit8($cd[6],1), getBit8($cd[4],3), getBit8($cd[3],4), getBit8($cd[3],7));
  }

  return $keys;  // 16 arrays of 6 bytes
}

function shiftLeft($in28, $num){  // 4 of 7bits
  $out28 = array();

  if($num == 1){
    $out28[] = mergeBits7(getBit7($in28[0], 1), getBit7($in28[0], 2), getBit7($in28[0], 3), getBit7($in28[0], 4),
                          getBit7($in28[0], 5), getBit7($in28[0], 6), getBit7($in28[1], 0));
    $out28[] = mergeBits7(getBit7($in28[1], 1), getBit7($in28[1], 2), getBit7($in28[1], 3), getBit7($in28[1], 4),
                          getBit7($in28[1], 5), getBit7($in28[1], 6), getBit7($in28[2], 0));
    $out28[] = mergeBits7(getBit7($in28[2], 1), getBit7($in28[2], 2), getBit7($in28[2], 3), getBit7($in28[2], 4),
                          getBit7($in28[2], 5), getBit7($in28[2], 6), getBit7($in28[3], 0));
    $out28[] = mergeBits7(getBit7($in28[3], 1), getBit7($in28[3], 2), getBit7($in28[3], 3), getBit7($in28[3], 4),
                          getBit7($in28[3], 5), getBit7($in28[3], 6), getBit7($in28[0], 0));
  } else {
    $out28[] = mergeBits7(getBit7($in28[0], 2), getBit7($in28[0], 3), getBit7($in28[0], 4), getBit7($in28[0], 5),
                          getBit7($in28[0], 6), getBit7($in28[1], 0), getBit7($in28[1], 1));
    $out28[] = mergeBits7(getBit7($in28[1], 2), getBit7($in28[1], 3), getBit7($in28[1], 4), getBit7($in28[1], 5),
                          getBit7($in28[1], 6), getBit7($in28[2], 0), getBit7($in28[2], 1));
    $out28[] = mergeBits7(getBit7($in28[2], 2), getBit7($in28[2], 3), getBit7($in28[2], 4), getBit7($in28[2], 5),
                          getBit7($in28[2], 6), getBit7($in28[3], 0), getBit7($in28[3], 1));
    $out28[] = mergeBits7(getBit7($in28[3], 2), getBit7($in28[3], 3), getBit7($in28[3], 4), getBit7($in28[3], 5),
                          getBit7($in28[3], 6), getBit7($in28[0], 0), getBit7($in28[0], 1));
  }

  return $out28;  // 4 of 7bits
}

function expand($in32){ // array of 4 bytes

  $out48 = array();

  // 31 00 01 02 03 04 03 04
  $out48[] = mergeBits8(getBit8($in32[3], 7), getBit8($in32[0], 0), getBit8($in32[0], 1), getBit8($in32[0], 2),
                        getBit8($in32[0], 3), getBit8($in32[0], 4), getBit8($in32[0], 3), getBit8($in32[0], 4));
  
  // 05 06 07 08 07 08 09 10                    
  $out48[] = mergeBits8(getBit8($in32[0], 5), getBit8($in32[0], 6), getBit8($in32[0], 7), getBit8($in32[1], 0), 
                        getBit8($in32[0], 7), getBit8($in32[1], 0), getBit8($in32[1], 1), getBit8($in32[1], 2));

  // 11 12 11 12 13 14 15 16
  $out48[] = mergeBits8(getBit8($in32[1], 3), getBit8($in32[1], 4), getBit8($in32[1], 3), getBit8($in32[1], 4),
                        getBit8($in32[1], 5), getBit8($in32[1], 6), getBit8($in32[1], 7), getBit8($in32[2], 0));
  
  // 15 16 17 18 19 20 19 20
  $out48[] = mergeBits8(getBit8($in32[1], 7), getBit8($in32[2], 0), getBit8($in32[2], 1), getBit8($in32[2], 2),
                        getBit8($in32[2], 3), getBit8($in32[2], 4), getBit8($in32[2], 3), getBit8($in32[2], 4));

  // 21 22 23 24 23 24 25 26
  $out48[] = mergeBits8(getBit8($in32[2], 5), getBit8($in32[2], 6), getBit8($in32[2], 7), getBit8($in32[3], 0),
                        getBit8($in32[2], 7), getBit8($in32[3], 0), getBit8($in32[3], 1), getBit8($in32[3], 2));

  // 27 28 27 28 29 30 31 00
  $out48[] = mergeBits8(getBit8($in32[3], 3), getBit8($in32[3], 4), getBit8($in32[3], 3), getBit8($in32[3], 4),
                        getBit8($in32[3], 5), getBit8($in32[3], 6), getBit8($in32[3], 7), getBit8($in32[0], 0));
  
  return $out48;  // array of 6 bytes
}

function sBoxes($in48){ // use 8 s boxes, 6 to 4 bits each
  // split 6 bytes into 8 groups
  $sixbits = array();
  
  $sixbits[] = mergeBits6(getBit8($in48[0], 0), getBit8($in48[0], 1), getBit8($in48[0], 2),
                          getBit8($in48[0], 3), getBit8($in48[0], 4), getBit8($in48[0], 5));

  $sixbits[] = mergeBits6(getBit8($in48[0], 6), getBit8($in48[0], 7), getBit8($in48[1], 0),
                          getBit8($in48[1], 1), getBit8($in48[1], 2), getBit8($in48[1], 3));

  $sixbits[] = mergeBits6(getBit8($in48[1], 4), getBit8($in48[1], 5), getBit8($in48[1], 6),
                          getBit8($in48[1], 7), getBit8($in48[2], 0), getBit8($in48[2], 1));

  $sixbits[] = mergeBits6(getBit8($in48[2], 2), getBit8($in48[2], 3), getBit8($in48[2], 4),
                          getBit8($in48[2], 5), getBit8($in48[2], 6), getBit8($in48[2], 7));

  $sixbits[] = mergeBits6(getBit8($in48[3], 0), getBit8($in48[3], 1), getBit8($in48[3], 2),
                          getBit8($in48[3], 3), getBit8($in48[3], 4), getBit8($in48[3], 5));

  $sixbits[] = mergeBits6(getBit8($in48[3], 6), getBit8($in48[3], 7), getBit8($in48[4], 0),
                          getBit8($in48[4], 1), getBit8($in48[4], 2), getBit8($in48[4], 3));

  $sixbits[] = mergeBits6(getBit8($in48[4], 4), getBit8($in48[4], 5), getBit8($in48[4], 6),
                          getBit8($in48[4], 7), getBit8($in48[5], 0), getBit8($in48[5], 1));

  $sixbits[] = mergeBits6(getBit8($in48[5], 2), getBit8($in48[5], 3), getBit8($in48[5], 4),
                          getBit8($in48[5], 5), getBit8($in48[5], 6), getBit8($in48[5], 7));

  // run sBox on each group
  // combine 8 output nibbles into 4 bytes
  $out32 = array();
  for($i = 0; $i < 8; $i += 2)
    $out32[] = mergeNibbles(sBox($sixbits[$i], $i), sBox($sixbits[$i + 1], $i + 1));

  return $out32;
}

function sBox($in6, $num){  // in6 is just a number, num is which box to use

  $x = getBit6($in6, 1)*8 + getBit6($in6, 2)*4 + getBit6($in6, 3)*2 + getBit6($in6, 4);
  $y = getBit6($in6, 0)*2 + getBit6($in6, 6);
  
  $boxes = array();
  $boxes[] = [
    [14, 4, 13, 1, 2, 15, 11, 8, 3, 10, 6, 12, 5, 9, 0, 7],
    [0, 15, 7, 4, 14, 2, 13, 1, 10, 6, 12, 11, 9, 5, 3, 8],
    [4, 1, 14, 8, 13, 6, 2, 11, 15, 12, 9, 7, 3, 10, 5, 0],
    [15, 12, 8, 2, 4, 9, 1, 7, 5, 11, 3, 14, 10, 0, 6, 13]
  ];
  $boxes[] = [
    [15, 1, 8, 14, 6, 11, 3, 4, 9, 7, 2, 13, 12, 0, 5, 10],
    [3, 13, 4, 7, 15, 2, 8, 14, 12, 0, 1, 10, 6, 9, 11, 5],
    [0, 14, 7, 11, 10, 4, 13, 1, 5, 8, 12, 6, 9, 3, 2, 15],
    [13, 8, 10, 1, 3, 15, 4, 2, 11, 6, 7, 12, 0, 5, 14, 9]
  ];
  $boxes[] = [
    [10, 0, 9, 14, 6, 3, 15, 5, 1, 13, 12, 7, 11, 4, 2, 8],
    [13, 7, 0, 9, 3, 4, 6, 10, 2, 8, 5, 14, 12, 11, 15, 1],
    [13, 6, 4, 9, 8, 15, 3, 0, 11, 1, 2, 12, 5, 10, 14, 7],
    [1, 10, 13, 0, 6, 9, 8, 7, 4, 15, 14, 3, 11, 5, 2, 12]
  ];
  $boxes[] = [
    [7, 13, 14, 3, 0, 6, 9, 10, 1, 2, 8, 5, 11, 12, 4, 15],
    [13, 8, 11, 5, 6, 15, 0, 3, 4, 7, 2, 12, 1, 10, 14, 9],
    [10, 6, 9, 0, 12, 11, 7, 13, 15, 1, 3, 14, 5, 2, 8, 4],
    [3, 15, 0, 6, 10, 1, 13, 8, 9, 4, 5, 11, 12, 7, 2, 14]
  ];
  $boxes[] = [
    [2, 12, 4, 1, 7, 10, 11, 6, 8, 5, 3, 15, 13, 0, 14, 9],
    [14, 11, 2, 12, 4, 7, 13, 1, 5, 0, 15, 10, 3, 9, 8, 6],
    [4, 2, 1, 11, 10, 13, 7, 8, 15, 9, 12, 5, 6, 3, 0, 14],
    [11, 8, 12, 7, 1, 14, 2, 13, 6, 15, 0, 9, 10, 4, 5, 3]
  ];
  $boxes[] = [
    [12, 1, 10, 15, 9, 2, 6, 8, 0, 13, 3, 4, 14, 7, 5, 11],
    [10, 15, 4, 2, 7, 12, 9, 5, 6, 1, 13, 14, 0, 11, 3, 8],
    [9, 14, 15, 5, 2, 8, 12, 3, 7, 0, 4, 10, 1, 13, 11, 6],
    [4, 3, 2, 12, 9, 5, 15, 10, 11, 14, 1, 7, 6, 0, 8, 13]
  ];
  $boxes[] = [
    [4, 11, 2, 14, 15, 0, 8, 13, 3, 12, 9, 7, 5, 10, 6, 1],
    [13, 0, 11, 7, 4, 9, 1, 10, 14, 3, 5, 12, 2, 15, 8, 6],
    [1, 4, 11, 13, 12, 3, 7, 14, 10, 15, 6, 8, 0, 5, 9, 2],
    [6, 11, 13, 8, 1, 4, 10, 7, 9, 5, 0, 15, 14, 2, 3, 12]
  ];
  $boxes[] = [
    [13, 2, 8, 4, 6, 15, 11, 1, 10, 9, 3, 14, 5, 0, 12, 7],
    [1, 15, 13, 8, 10, 3, 7, 4, 12, 5, 6, 11, 0, 14, 9, 2],
    [7, 11, 4, 1, 9, 12, 14, 2, 0, 6, 10, 13, 15, 3, 5, 8],
    [2, 1, 14, 7, 4, 10, 8, 13, 15, 12, 9, 0, 3, 5, 6, 11]
  ];

  return $boxes[$num][$x][$y];
}

function pBox($in32){

  $out32 = array();

  // 15 06 19 20 28 11 27 16
  $out32[] = mergeBits8(getBit8($in32[1], 7), getBit8($in32[0], 6), getBit8($in32[2], 3), getBit8($in32[2], 4),
                        getBit8($in32[3], 4), getBit8($in32[1], 3), getBit8($in32[3], 3), getBit8($in32[2], 0));
  
  // 00 14 22 25 04 17 30 09
  $out32[] = mergeBits8(getBit8($in32[0], 0), getBit8($in32[1], 6), getBit8($in32[2], 6), getBit8($in32[3], 1),
                        getBit8($in32[0], 4), getBit8($in32[2], 1), getBit8($in32[3], 6), getBit8($in32[1], 1));

  // 01 07 23 13 31 26 02 08
  $out32[] = mergeBits8(getBit8($in32[0], 1), getBit8($in32[0], 7), getBit8($in32[2], 7), getBit8($in32[1], 5),
                        getBit8($in32[3], 7), getBit8($in32[3], 2), getBit8($in32[0], 2), getBit8($in32[1], 0));
  
  // 18 12 29 05 21 10 03 24
  $out32[] = mergeBits8(getBit8($in32[2], 2), getBit8($in32[1], 4), getBit8($in32[3], 5), getBit8($in32[0], 5),
                        getBit8($in32[2], 5), getBit8($in32[1], 2), getBit8($in32[0], 3), getBit8($in32[3], 0));
  
  return $out32;
}

function getBit8($byte, $num){  // 0 is far left, 7 is far right
  return ($byte & (128 >> $num)) != 0 ? 1 : 0;
}

function getBit7($sevenBit, $num){
  return ($sevenBit & (64 >> $num)) != 0 ? 1 : 0;
}

function getBit6($sixBit, $num){
  return ($sixBit & (32 >> $num)) != 0 ? 1 : 0;
}

function mergeBits56($left28, $right28){  // arrays of 4 7bits

  $out56 = array();

  $out56[] = mergeBits8(getBit7($left28[0], 0), getBit7($left28[0], 1), getBit7($left28[0], 2), getBit7($left28[0], 3),
                        getBit7($left28[0], 4), getBit7($left28[0], 5), getBit7($left28[0], 6), getBit7($left28[1], 0));
  $out56[] = mergeBits8(getBit7($left28[1], 1), getBit7($left28[1], 2), getBit7($left28[1], 3), getBit7($left28[1], 4),
                        getBit7($left28[1], 5), getBit7($left28[1], 6), getBit7($left28[2], 0), getBit7($left28[2], 1));
  $out56[] = mergeBits8(getBit7($left28[2], 2), getBit7($left28[2], 3), getBit7($left28[2], 4), getBit7($left28[2], 5),
                        getBit7($left28[2], 6), getBit7($left28[3], 0), getBit7($left28[3], 1), getBit7($left28[3], 2));
  $out56[] = mergeBits8(getBit7($left28[3], 3), getBit7($left28[3], 4), getBit7($left28[3], 5), getBit7($left28[3], 6),
                        getBit7($right28[0], 0), getBit7($right28[0], 1), getBit7($right28[0], 2), getBit7($right28[0], 3));
  $out56[] = mergeBits8(getBit7($right28[0], 4), getBit7($right28[0], 5), getBit7($right28[0], 6), getBit7($right28[1], 0),
                        getBit7($right28[1], 1), getBit7($right28[1], 2), getBit7($right28[1], 3), getBit7($right28[1], 4));
  $out56[] = mergeBits8(getBit7($right28[1], 5), getBit7($right28[1], 6), getBit7($right28[2], 0), getBit7($right28[2], 1),
                        getBit7($right28[2], 2), getBit7($right28[2], 3), getBit7($right28[2], 4), getBit7($right28[2], 5));
  $out56[] = mergeBits8(getBit7($right28[2], 6), getBit7($right28[3], 0), getBit7($right28[3], 1), getBit7($right28[3], 2),
                        getBit7($right28[3], 3), getBit7($right28[3], 4), getBit7($right28[3], 5), getBit7($right28[3], 6));
  
  return $out56;  // array of 7 bytes
}

function mergeBits8($b0, $b1, $b2, $b3, $b4, $b5, $b6, $b7){
  return $b0*128 + $b1*64 + $b2*32 + $b3*16 + $b4*8 + $b5*4 + $b6*2 + $b7;
}

function mergeBits7($b0, $b1, $b2, $b3, $b4, $b5, $b6){
  return $b0*64 + $b1*32 + $b2*16 + $b3*8 + $b4*4 + $b5*2 + $b6;
}

function mergeBits6($b0,$b1, $b2, $b3, $b4, $b5){
  return $b0*32 + $b1*16 + $b2*8 + $b3*4 + $b4*2 + $b5;
}

function mergeNibbles($n0, $n1){
  return $n0*16 + $n1;
}

//DES CIPHER CODE END
?>

<?php
    // cipher methods: turn plaintext to ciphertext with a key
    // decipher methods: turn ciphertext into plaintext with a key

    // 5 starred ciphers are required for project
   
    // *****simple substitution
    // *****double transposition
    // *****RC4
    // *****DES cipher
?>