import {useState,useEffect} from "react";
import Navbar from "./Navbar";
import {Text,Box} from "@chakra-ui/react";
import LineChartAssetsHome from "./LineChartAssetsHome";
import axios from "axios";


function Compare(){
    const [replyData1, setReplyData1] = useState<any[]>([]);
    const [likeData1, setLikeData1] = useState<any[]>([]);
    const [viewData1, setViewData1] = useState<any[]>([]);
    const [replyData2, setReplyData2] = useState<any[]>([]);
    const [likeData2, setLikeData2] = useState<any[]>([]);
    const [viewData2, setViewData2] = useState<any[]>([]);
    const token = localStorage.getItem('token')!;
    const idownerinteger = parseInt(localStorage.getItem('id')!);
    const params = new URLSearchParams(location.search)
    const id1 = params.get('id1');
    const id2 = params.get('id2');
    useEffect(()=>{
        let urlview1 = 'http://localhost:3030/post/view/'+idownerinteger+"/"+id1;
        let urlreply1 = 'http://localhost:3030/post/reply/'+idownerinteger+"/"+id1;
        let urllike1 = 'http://localhost:3030/post/like/'+idownerinteger+"/"+id1;
        let urlview2 = 'http://localhost:3030/post/view/'+idownerinteger+"/"+id2;
        let urlreply2 = 'http://localhost:3030/post/reply/'+idownerinteger+"/"+id2;
        let urllike2 = 'http://localhost:3030/post/like/'+idownerinteger+"/"+id2;
        axios.get(urlview1,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setViewData1(res.data);
        })
        axios.get(urlreply1,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setReplyData1(res.data);
        })
        axios.get(urllike1,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setLikeData1(res.data);
        })
        axios.get(urlview2,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setViewData2(res.data);
        })
        axios.get(urlreply2,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setReplyData2(res.data);
        })
        axios.get(urllike2,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
            setLikeData2(res.data);
        })
    },[])

    console.log(id1);
    console.log(id2);
    return(
        <div>
        <Navbar/>
        <Box marginTop='80px'>
            <Box position="absolute"
            right={350}
            height="100vh"
            width="240px"  
           >
                <Text fontSize="4xl" fontWeight="bold" fontFamily="heading" color="teal.500">
                    POST ID : {id1}
                </Text>
                <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                    Reply
                </Text>
                <LineChartAssetsHome data={replyData1} />
                <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                    View
                </Text>
                <LineChartAssetsHome data={viewData1} />
                <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                    Likes
                </Text>
                <LineChartAssetsHome data={likeData1} />
            </Box>
            <Box>
            <Text fontSize="4xl" fontWeight="bold" fontFamily="heading" color="teal.500">
                POST ID : {id2}
            </Text>
            <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                Reply
            </Text>
            <LineChartAssetsHome data={replyData2} />
            <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                View
            </Text>
            <LineChartAssetsHome data={viewData2} />
            <Text fontSize="xl" fontFamily="body" color="gray.600" marginTop="4" marginLeft="3">
                Likes
            </Text>
            <LineChartAssetsHome data={likeData2} />
            </Box>


        </Box>
        </div>
        
    )
}

export default Compare;