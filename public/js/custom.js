
/* number to word convert */
function convertNumberToWords(num) {
    var ones = ["", "One ", "Two ", "Three ", "Four ", "Five ", "Six ", "Seven ", "Eight ", "Nine ", "Ten ", "Eleven ", "Twelve ", "Thirteen ", "Fourteen ", "Fifteen ", "Sixteen ", "Seventeen ", "Eighteen ", "Nineteen "];
    var tens = ["", "", "Twenty ", "Thirty ", "Forty ", "Fifty ", "Sixty ", "Seventy ", "Eighty ", "Ninety "];

    if ((num = num.toString()).length > 33) return "Overflow: Maximum 33 digits supported";

    var words = 'Rupees ';

    function convertThreeDigits(num) {
        var result = '';

        if (num >= 100) {
            result += ones[Math.floor(num / 100)] + "Hundred ";
            num %= 100;
        }

        if (num >= 20) {
            result += tens[Math.floor(num / 10)];
            num %= 10;
        }

        if (num > 0) {
            result += ones[num];
        }

        return result;
    }

    var billion = Math.floor(num / 10000000);
    num %= 10000000;
    var crore = Math.floor(num / 10000000);
    num %= 10000000;
    var lakh = Math.floor(num / 100000);
    num %= 100000;
    var thousand = Math.floor(num / 1000);
    num %= 1000;
    var hundred = Math.floor(num / 100);
    num %= 100;

    if (billion) {
        words += convertThreeDigits(billion) + "Crore ";
    }

    if (crore) {
        words += convertThreeDigits(crore) + "Crore ";
    }

    if (lakh) {
        words += convertThreeDigits(lakh) + "Lakh ";
    }

    if (thousand) {
        words += convertThreeDigits(thousand) + "Thousand ";
    }

    if (hundred) {
        words += convertThreeDigits(hundred) + "Hundred ";
    }

    if (num) {
        words += convertThreeDigits(num);
    }
    words += "Only ";
    return words.trim();
}


// // Test the function
// var number = 53957128.00;
// var words = convertNumberToWords(number);
// console.log(words);

/* JsonData search and show */

// Function to find a node by its ID and its parent
function findNodeHierarchyByIdInArray(array, id) {
    let result = null;
    array.some(obj => {
      result = findNodeHierarchyById(obj, id);
      return result !== null;
    });
    return result;
  }


  // Function to find a node by its ID and its parent
  function findNodeHierarchyById(node, id, parent = null, grandParent = null, hierarchy = []) {
    if (node.id === id) {
      return { node, parent, grandParent, hierarchy };
    } else if (node._subrow) {
      let result = null;
      for (const subNode of node._subrow) {
        result = findNodeHierarchyById(subNode, id, node, parent, hierarchy.concat(node));
        if (result) {
          return result;
        }
      }
    }
    return null;
  }

  // Function to get the details of the hierarchy
  function getHierarchyDetails(jsonData, nodeIdToFind) {
    const result = findNodeHierarchyByIdInArray(jsonData, nodeIdToFind);
    if (result !== null) {
      const { node, parent, grandParent, hierarchy } = result;
      const details = [];
      hierarchy.forEach(item => {
        const cleanedItemNo = item.item_no.replace(/\[.*\]/g, ''); // Remove brackets
        details.push(`${cleanedItemNo}) ${item.desc_of_item}`);
      });
      const cleanedItemNo = node.item_no.replace(/\[.*\]/g, ''); // Remove brackets
      details.push(`${cleanedItemNo}) ${node.desc_of_item}`);
    //   details.forEach(detail => console.log(detail));
      return details;
    } else {
      return ["Node not found"];
    }
  }





/* Alpine using global use in project */
document.addEventListener("alpine:init",()=>{
    Alpine.data('taxes', () => ({
        taxData: [],
        async fetchData(){
            try{
                const response = await fetch("{{route('getTax')}}");
                this.taxData = await response.json();
                console.log(this.taxData);
            }
            catch(error)
            {
                console.error('Error fetching data:', error);
            }
        }

    }));
});
