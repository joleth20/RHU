<?php
$services_array = array(
    'Pulmonary' => array('Acute respiratory infections (ARI)', 'Tuberculosis', 'Pneumonia', 'Asthma in children', 'Others'
    ),
    'Cardio' => array('Hypertension', 'Rheumatic heart disease', 'Congestive heart failure', 'Peripheral artery disease', 'Deep vein thrombosis', 'Others'
    ),
    'Surgery' => array('Abscesses', 'Minor wounds and injuries', 'Inguinal hernia', 'Appendicitis', 'Skin infections', 'General surgery', 'Others'
    ),
    'Pedia' => array('Malnutrition in children', 'Diarrheal diseases in children', 'Pediatric respiratory infections', 'Vaccine-preventable diseases in children', 'Pediatric skin infections', 'Others'
    ),
    'General' => array('Gastroenteritis', 'Urinary tract infections', 'Sexually transmitted infections', 'Dermatological conditions', 'Nutritional deficiencies', 'Others'
    )
);
// $services = "Cardio";
// foreach ($services_array as $services_key => $services_value) {
//
//   if ($services == $services_key) {
//     $selected_services = "selected";
//     echo $selected_services." is ".$services_key."<br>";
//   }else{
//     echo $services_key."<br>";
//   }
//
//
// }


 ?>
<!-- <script>
 function catch_value_types() {
   const selectedValue = document.getElementById("types").value;
   const select2 = document.getElementById("food");
   Array.from(select2.options).forEach((node) => node.style.display = node.id === selectedValue ? "block": "none");
 }
</script>

<select onchange="catch_value_types()" name="types" id="types">
  <option value="Pedia" id="Pedia">Pedia</option>
  <option value="Pulmonary" id="Pulmonary">Pulmonary</option>
  <option value="Cardio" id="Cardio">Cardio</option>
  <option value="Surgery" id="Surgery">Surgery</option>
  <option value="General" id="General">General</option>
</select>

<select name="food" id="food">
  <option>Please Select</option>
  <option value="Fever" id="Pedia">Fever</option>
  <option value="Cough"id="Pedia">Cough</option>
  <option value="Cold" id="Pedia">Cold</option>
  <option value="Concern1" id="Pulmonary">Concern1</option>
  <option value="Concern2" id="Pulmonary">Concern2</option>
  <option value="Concern3" id="Pulmonary">Concern3</option>
  <option value="test1" id="Cardio">test1</option>
  <option value="test2" id="Cardio">test2</option>
  <option value="test3" id="Cardio">test3</option>
</select> -->
