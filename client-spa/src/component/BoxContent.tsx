import {Box,Text, Button} from '@chakra-ui/react';
import { useLocation } from "react-router-dom"
// import React from 'react';

const BoxContent = ({ data }:any) => {
    const location = useLocation()
    const params = new URLSearchParams(location.search)
    const id = params.get('id');
    const usernameowner = localStorage.getItem('username')
    let buttondetail;
    if(id === null){
        buttondetail = <Button colorScheme='blue' mt='10px' onClick={() => window.location.href='/tweet-analytic?id='+data.post_id}>
        Detail
    </Button>
    }
    else{
    }
    const username = localStorage.getItem('username')!;
    return (
        <Box border='1px solid gray' borderRadius='10px' p='20px' mt='20px' wordBreak='break-word'>
            <Box borderBottom='1px solid gray' pb='10px' mb='10px' wordBreak='break-word'>
                <Text>
                    @{username}
                </Text>
            </Box>
            <Text>
                Post ID : {data.post_id}
            </Text>
            {buttondetail}
            <Button marginLeft={5} colorScheme='facebook' mt='10px' onClick={() => window.location.href='http://localhost:8008/post/'+usernameowner+"/"+data.post_id}>
                To Post
            </Button>
        </Box>
    );
}
export default BoxContent;