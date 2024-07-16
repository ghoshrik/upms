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
        details.push(`${cleanedItemNo} ${item.desc_of_item}`);
      });
      const cleanedItemNo = node.item_no.replace(/\[.*\]/g, ''); // Remove brackets
      details.push(`${cleanedItemNo} ${node.desc_of_item}`);
    //   details.forEach(detail => console.log(detail));
      return details;
    } else {
      return ["Node not found"];
    }
  }
