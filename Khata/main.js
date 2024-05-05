let pop = document.getElementById("popup_background");
        let createButton = document.getElementById("create_button");
        let increaseAmountButton = document.getElementById("increase_button");
        let decreaseAmountButton = document.getElementById("decrease_button");
        let inputName = document.getElementById("name_input");
        let inputAmount = document.getElementById("amount_input");
        let targetButton = document.getElementById("buttons");
        let targetInput = document.getElementById("popup");
        let targetPopup = document.getElementById("body")
        let confirm_button = document.getElementById("confirm_button");
        let cancel_button = document.getElementById("cancel_button");
        let popup_container =document.getElementById("popup_container");
        let popup_close_button = document.getElementById("popup_close_button");
        let user_name = document.getElementById("user_name");

        

        function createPopup()
        {
            targetPopup.appendChild(pop);
            targetButton.innerHTML = "";
            targetInput.appendChild(targetButton);
            if(!targetInput.querySelector("#name_input")) targetInput.insertBefore(inputName, targetInput.childNodes[2]);
            if(!targetInput.querySelector("#amount_input")) targetInput.insertBefore(inputAmount, targetInput.childNodes[3]);
            targetButton.appendChild(createButton);
            document.getElementById("command_text").innerText = "New Borrower";
            inputName.focus();
        }

        function popdown()
        {
            targetPopup.removeChild(pop);
            popup_container.style = "display : inline;";
            popup_close_button.style = "top : -15px; left : 305px";
        }

        let decreases = document.querySelectorAll('.modify_button');
        decreases.forEach(function(element)
        {
            element.onclick = function(){
                targetPopup.appendChild(pop);
                targetButton.innerHTML = "";
                document.getElementById("hidden_input").value = element.id;
                if(targetInput.querySelector("#name_input")) targetInput.removeChild(inputName);
                if(!targetInput.querySelector("#amount_input")) targetInput.appendChild(inputAmount);
                targetInput.appendChild(targetButton);
                targetButton.appendChild(decreaseAmountButton);
                targetButton.appendChild(increaseAmountButton);
                document.getElementById("command_text").innerText = "Modify Amount";
                inputAmount.focus();
            }
            
        });

        function confirm(nth)
        {
            targetPopup.appendChild(pop);
            popup_container.style = "display : grid;";
            popup_close_button.style = "top : -36px; left : 303px";
            targetButton.innerHTML = "";
            if(targetInput.querySelector("#name_input")) targetInput.removeChild(inputName);
            if(targetInput.querySelector("#amount_input")) targetInput.removeChild(inputAmount);
            document.getElementById("command_text").innerText = "Has amount paid?";
            targetInput.appendChild(targetButton);
            targetButton.appendChild(confirm_button);
            targetButton.appendChild(cancel_button);
            document.getElementById("confirm_button").href="main.php?username=<?php echo $table ?> & delId=".concat(nth);
        }

        if(window.history.replaceState)
        {
            window.history.replaceState(null, null, window.location.href);
        }

        // Navbar
        document.getElementById("get_started_button").innerText = "Log Out";
        document.getElementById("search").style = "display:inline;";
        document.getElementById("search_icon").style = "display:inline;";
        document.getElementById("user").style = "display:flex;";
        document.getElementById("get_started_button").onclick =function(){
            window.location.href = "http://localhost/khata/index.php";
        }
        document.getElementById("search_icon_image").onclick =function(){
            var username = document.getElementById("input_search").value;
            window.location.href = "main.php?username=<?php echo $table ?>" +`&search=${username}`;
        }
        function h(){console.log(done)};
        document.getElementById("search").onsubmit = function(){
            console.log("done");
        }
