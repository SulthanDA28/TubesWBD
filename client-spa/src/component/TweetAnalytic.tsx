import {useState,useEffect} from 'react'
import LineChartAssets from './LineChartAssets';
import {Box, Text} from '@chakra-ui/react';
import BoxContent from './BoxContent';
import Navbar from './Navbar';
import { useLocation } from "react-router-dom"
import axios from 'axios';

interface Data {
    day: string;
    total: number;
}
interface Content{
    username : string;
    id : number;
    profile_name : string;
    post_id : number;
    body : string;
    created_at : string;
    path : string;
}
function TweetAnalytic(){
    if(localStorage.getItem('username') === null){
        window.location.href = '/login';
    }
    const location = useLocation()
    const params = new URLSearchParams(location.search)
    const id = params.get('id');
    const idowner = localStorage.getItem('id')!;
    const idownerinteger = parseInt(idowner);
    const token = localStorage.getItem('token')!;

    if(id === null){
        useEffect(()=>{
            let urlview = 'http://localhost:3030/post/view/'+idownerinteger;
            let urlreply = 'http://localhost:3030/post/reply/'+idownerinteger;
            let urllike = 'http://localhost:3030/post/like/'+idownerinteger;
            let urlcontent = 'http://localhost:3030/post/'+idownerinteger;
            axios.get(urlview,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setViewData(res.data);
            })
            axios.get(urlreply,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setReplyData(res.data);
            })
            axios.get(urllike,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setLikeData(res.data);
            })
            axios.get(urlcontent,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setContent(res.data);
            })
        },[])

    }
    else{
        useEffect(()=>{
            let urlview = 'http://localhost:3030/post/view/'+idownerinteger+"/"+id;
            let urlreply = 'http://localhost:3030/post/reply/'+idownerinteger+"/"+id;
            let urllike = 'http://localhost:3030/post/like/'+idownerinteger+"/"+id;
            let urlcontent = 'http://localhost:3030/post/'+idownerinteger+"/"+id;
            axios.get(urlview,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setViewData(res.data);
            })
            axios.get(urlreply,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setReplyData(res.data);
            })
            axios.get(urllike,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setLikeData(res.data);
            })
            axios.get(urlcontent,{ headers: { Authorization: `Bearer ${token}` } }).then((res)=>{
                setContent(res.data);
            })
        },[])
    }
    const initialData = [
        { day : 'Mon' , total : 0 },
        { day : 'Tue' , total : 0 },
        { day : 'Wed' , total : 0 },
        { day : 'Thu' , total : 0 },
        { day : 'Fri' , total : 0 },
        { day : 'Sat' , total : 0 },
        { day : 'Sun' , total : 0 },
    ];
    const [replyData, setReplyData] = useState<Data[]>(initialData);
    const [likeData, setLikeData] = useState<Data[]>(initialData);
    const [viewData, setViewData] = useState<Data[]>(initialData);
    const [content, setContent] = useState<Content[]>([]);

    //Set Data

    const makeContentBox = () => {
        let contentBox = [];
        for (let i = 0; i < content.length; i++) {
            contentBox.push(<BoxContent data={content[i]} key={content[i].post_id} />)
        }
        return contentBox;
    }
    return (
        <div>
            <Navbar />
            <Box
            marginRight="240px"
            marginTop="80px"
            >
                {makeContentBox()}
            </Box>
            <Box
            position="fixed"
            right="0"
            top="78px"
            height="100vh"
            width="240px"  
            overflowX="auto"
            padding="4">
                <Text fontSize="xl" fontWeight="bold">Like</Text>
                <LineChartAssets data={likeData} />
                <Text fontSize="xl" fontWeight="bold">Views</Text>
                <LineChartAssets data={viewData} />
                <Text fontSize="xl" fontWeight="bold">Replies</Text>
                <LineChartAssets data={replyData} />
            </Box>
            
        </div>
    )
}

export default TweetAnalytic;