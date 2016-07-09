<?php
	require("../model/page_functions.php");
	if(!isset($_GET["page_id"])) {
		die("No page id found");
	}
	$page_id = $_GET["page_id"];
	if(!($page = load_page($page_id))) {
		die("Invalid Page Id");
	}
	require("../model/panel_functions.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<style>
			html,body {
				height: 95%;
				width: 95%;
				display: table;
				position: relative;
			}
			.panel {
				border: 1px solid red;
				overflow: hidden;
			}
			.left, .right {
				display: table-column;
			}
			.top, .bottom {
				display: flex;
			}
		</style>
	</head>
	<body>
		<?php load_panel($page_id,0,"edit"); var_dump($panel_tracker);?>
	</body>
	<script>

		function setAttributes(el, options) {
			Object.keys(options).forEach(function(attr) {
				el.setAttribute(attr, options[attr]);
			});
		};

		function newElement(element,options) {
			var newElement = document.createElement(element);
			setAttributes(newElement,options);
			return newElement;
		};

		var split_panel_called = [];
		var split_panel = function(panel_id) {
			if(split_panel_called.indexOf(panel_id) != -1) {
				return;
			} else {
				split_panel_called.push(panel_id);
			}
			console.log(panel_id);
			var panel = document.getElementById(panel_id);
			
			var sub_panels_form = newElement('form',{"action": "process_input.php", "method": "POST"});

			var page_id = newElement('input',{"type": "hidden","name": "page_id", "value": <?php echo $page_id; ?> });
			var panel_id = newElement('input',{"type": "hidden","name": "panel_id", "value": panel_id});

			var horizontal_split = newElement('input',{"type": "radio", "name": "cut_direction", "value": "horizontal"});
			var vertical_split = newElement('input',{"type": "radio", "name": "cut_direction", "value": "vertical"});
			var specify = newElement('input',{"type": "number", "name": "height_width", "min": 0, "max": 100});
			var submitButton = newElement('button',{"type": "submit"});
			submitButton.innerHTML = "Split Panel";

			sub_panels_form.appendChild(page_id);
			sub_panels_form.appendChild(panel_id);
			sub_panels_form.appendChild(horizontal_split);
			sub_panels_form.innerHTML += "horizontal";
			sub_panels_form.appendChild(vertical_split);
			sub_panels_form.innerHTML += "vertical";
			sub_panels_form.innerHTML += "\n<br>specify height/width: ";
			sub_panels_form.appendChild(specify);
			sub_panels_form.appendChild(submitButton);
			panel.appendChild(sub_panels_form);
		};
	</script>
</html>