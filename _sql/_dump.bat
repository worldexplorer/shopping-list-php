@rem mysqldump --add-drop-table -ec -u shli -pshli shli > 1215-shli.dump
mysqldump --compatible=mysql40 -K --skip-add-locks --no-set-names --skip-disable-keys --default-character-set=utf8 --set-charset --add-drop-table -ec -u shli -pshli shli > 0709-shli-utf8.dump

@rem mysqldump --compatible=mysql40 -K --skip-add-locks --no-set-names --skip-disable-keys --set-charset --add-drop-table -ec -u shli -pshli shli shli_pgroup shli_product > 0821-shli-pgroup-product.dump
