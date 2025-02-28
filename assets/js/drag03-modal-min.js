console.log("API URL being used:",wpData.api_url),document.addEventListener("DOMContentLoaded",(async function(){var e=document.getElementById("cardModal"),t=new bootstrap.Modal(e,{backdrop:"static"}),o=null,n=[];function a(){let e=0,t=0,o=0;document.querySelectorAll(".card").forEach((n=>{let a=parseFloat(n.querySelector(".card-cost").textContent.replace("Total Cost: $",""))||0,r=n.dataset.type;"Cloud"===r?e+=a:"Decentralized"===r?t+=a:"On Prem"===r&&(o+=a)})),document.getElementById("total-cloud-cost").textContent=`$${e.toFixed(2)}`,document.getElementById("total-decentralized-cost").textContent=`$${t.toFixed(2)}`,document.getElementById("total-onprem-cost").textContent=`$${o.toFixed(2)}`}function r(){const e=document.getElementById("cardProvider"),t=e.options[e.selectedIndex],o=t.dataset.price?parseFloat(t.dataset.price):0,n=(parseInt(document.getElementById("cardNumber").value,10)||0)*o;document.getElementById("calculatedCost").textContent=`Total Cost: $${n.toFixed(2)}`}console.log("Fetching from API URL:",wpData.api_url),document.querySelectorAll(".card").forEach((e=>{e.setAttribute("draggable",!0),e.addEventListener("dragstart",(function(t){t.dataTransfer.setData("text/plain",JSON.stringify({cardId:e.dataset.cardId,row:e.dataset.row})),t.dataTransfer.effectAllowed="move",console.log("Dragging card ID:",e.dataset.cardId,"Row:",e.dataset.row)})),e.addEventListener("DOMSubtreeModified",a)})),document.querySelectorAll(".row[data-row]").forEach((e=>{e.querySelectorAll(".col[data-column]").forEach((t=>{t.addEventListener("dragover",(function(e){e.preventDefault(),e.dataTransfer.dropEffect="move"})),t.addEventListener("drop",(function(o){o.preventDefault();const n=JSON.parse(o.dataTransfer.getData("text/plain")),r=document.querySelector(`[data-card-id="${n.cardId}"][data-row="${n.row}"]`);r&&e.dataset.row===n.row&&(t.appendChild(r),function(e,t){let o;o="1"==t?"Cloud":"2"==t?"Decentralized":"On Prem";e.dataset.type=o}(r,t.dataset.column),a())}))}))})),document.querySelectorAll(".btn-edit-card").forEach((e=>{e.addEventListener("click",(function(e){e.stopPropagation();const a=(o=this.closest(".card")).querySelector(".card-title").textContent,d=o.querySelector(".card-text").textContent.replace("Number: ",""),c=o.querySelector(".provider-name").textContent,l=o.dataset.type;document.getElementById("cardTitle").value=a,document.getElementById("cardNumber").value=d,document.getElementById("cardProvider").innerHTML='<option value="0">Loading...</option>',function(e,t=null){const o=document.getElementById("cardProvider");o.innerHTML='<option value="0">- Please select</option>';const a=n.filter((t=>t.type===e));a.forEach((e=>{const n=document.createElement("option");n.value=e.provider,n.dataset.price=e.price,n.textContent=`${e.provider} - $${e.price} / TB`,t&&e.provider===t&&(n.selected=!0),o.appendChild(n)})),r()}(l,c),r(),t.show()}))})),document.getElementById("cardProvider").addEventListener("change",r),document.getElementById("cardNumber").addEventListener("input",r),document.getElementById("saveCardButton").addEventListener("click",(function(){if(!o)return;const e=document.getElementById("cardTitle").value,n=document.getElementById("cardProvider"),r=n.value,d=n.options[n.selectedIndex].dataset.price||"0.00",c=document.getElementById("cardNumber").value,l=(c*d).toFixed(2);console.log("Saving changes: ",{title:e,provider:r,providerPrice:d,numberTBs:c,totalCost:l}),o.querySelector(".card-title").textContent=e,o.querySelector(".provider-name").textContent="0.00"!==r?r:"No provider",o.querySelector(".card-text").textContent=`Number: ${c}`,o.querySelector(".card-cost").textContent=`Total Cost: $${l}`,a(),t.hide()})),await async function(){try{const e=await fetch(wpData.api_url);if(!e.ok)throw new Error("Failed to fetch data from API");n=await e.json(),console.log("Fetched Airtable Data:",n)}catch(e){console.error(e.message)}}()}));