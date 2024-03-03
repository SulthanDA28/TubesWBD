import {useState,useEffect} from "react";
import Navbar from "./Navbar";
import {Text,Box, Center, Checkbox,VStack} from "@chakra-ui/react";
import axios from "axios";


function SelectCompare(){
    const [content, setContent] = useState<any[]>([]);
    const [selectedOptions, setSelectedOptions] = useState<any[]>([]);
    

  const id = localStorage.getItem('id')!;
  const token = localStorage.getItem('token')!;

  useEffect(() => {
    let url = 'http://localhost:3030/post/' + id;
    axios.get(url, { headers: { Authorization: `Bearer ${token}` } }).then((res) => {
      setContent(res.data);
    });
  }, []);

  const handleCheckboxChange = (postId: number) => {
    const isSelected = selectedOptions.includes(postId);
    let newSelectedOptions;

    if (isSelected) {
      newSelectedOptions = selectedOptions.filter((selectedId) => selectedId !== postId);
      setSelectedOptions(newSelectedOptions);
    } else {
      // Ensure exactly two options are selected
      if (selectedOptions.length < 2) {
        newSelectedOptions = [...selectedOptions, postId];
        setSelectedOptions(newSelectedOptions);
      }
      else if(selectedOptions.length === 2){
        alert('You can only select 2 posts');
        
      }
    }
    
  };
  if(selectedOptions.length === 2){
    window.location.href = '/compare/content?id1='+selectedOptions[0]+'&id2='+selectedOptions[1];
  }
  

  return (
    <div>
        <Navbar />
      <Box marginTop="80px">
        <Center>
          <Text fontSize="4xl" fontWeight="bold" fontFamily="heading" color="teal.500">
            Select Compare
          </Text>
        </Center>
        <Center>
        <VStack spacing={4} align="flex-start" w="full">
          {content.map((item) => (
            <Box
              key={item.post_id}
              w="full"
              p={5}
              my={2}
              bg="gray.100"
              borderRadius="md"
              boxShadow="md"
            >
              <Checkbox colorScheme="green" size="lg" onChange={() => handleCheckboxChange(item.post_id)}>
                Post ID : {item.post_id}
              </Checkbox>
            </Box>
          ))}
        </VStack>
        </Center>
      </Box>
    </div>
  );
}

export default SelectCompare;