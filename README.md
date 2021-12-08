Back-end panaudota PHP, o front-end Vue.js karkasas bei bootstrap.

Pradžioje atvaizdavimui naudojau tik php ir bs (kas matosi old.view.php), tačiau vartotojo patogumui perėjau prie vue.js pridedant/trinant moksleivį bei atnaujinant grupę.
Post užklausa siunčiama per axios, o json informacija gaunama ir atnaujinama iš /data neperkraunant puslapio.
Kas 10 sekundžių informacija yra atnaujinama.
Projektų kūrimas ir moksleivio pridėjimas turi validaciją.
Taip pat tikrinama ar grupė yra pilna.
Nepraeinant validacijos ar esant pilnai grupei rodoma informacija viršuje.
Vienintelis kabliukas kurio dėl laiko stokos nepataisiau, tai jei atnaujinant grupę ji yra pilna, select'e užsilieka pasirinkta grupė.
