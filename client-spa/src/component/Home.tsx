import {useState,useEffect} from "react";
import Navbar from "./Navbar";
import {Text,Box, Center} from "@chakra-ui/react";
import LineChartAssetsHome from "./LineChartAssetsHome";
import axios from "axios";


function Home(){
    // const [username,setUsername] = useState('');
    const [name,setName] = useState('');
    const [followData,setFollowData] = useState<any[]>([]);
    const nama = localStorage.getItem('username')!;
    const id = localStorage.getItem('id')!;
    const idinteger = parseInt(id);
    const token = localStorage.getItem('token')!;
    useEffect(()=>{
        setName(nama);
        // setFollowData(FollowData);
        let url = 'http://localhost:3030/follow/'+idinteger;
        axios.get(url,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            console.log(res.data);
            setFollowData(res.data);
        })
    },[])
    if(localStorage.getItem('username') === null){
        window.location.href = '/login';
    }
    return(
        <div>
        <Box marginTop='80px'>
        <Navbar/>
        <Box>
        <Box textAlign="center" paddingTop="40px" >
        <Text fontSize="4xl" fontWeight="bold" fontFamily="heading" color="teal.500">
            Welcome Back {name}!
        </Text>
        <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4">
        Analytic Follow
        </Text>
        <Center>
        <LineChartAssetsHome data={followData} />
        </Center>
        </Box>
        </Box>
        </Box>
        </div>
        
    )
}

export default Home;