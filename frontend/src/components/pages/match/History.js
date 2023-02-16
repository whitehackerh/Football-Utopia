import { useState } from 'react';
import SideBar_Match from './SideBar_Match';
import CommonProfileCard from '../common/ProfileCard'; 
import MatchResult from './MatchResult';
import InfiniteScroll from "react-infinite-scroller";
import { withTokenRequest, requestHeaders } from '../../../http';
import { deleteBackSlash } from '../../../utils/function';
import noImage from "../../../assets/img/no image/noimage.png"

const History = () => {
    const [records, setRecords] = useState([]);
    const [hasMore, setHasMore] = useState(true);
    const [currentPage, setCurrentPage] = useState(0);
    const [isFetching, setIsFetching] = useState(false);
    const [profileCardUserId, setProfileCardUserId] = useState(null);
    const [isOpenProfileCard, setIsOpenProfileCard] = useState(false);
    const dateCash = Date.now();

    const getMatchHistory = async (page) => {
        setIsFetching(true);
        withTokenRequest.post('/getMatchHistory', {
            user_id: localStorage.getItem('user_id'),
            page: page
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (!res.data.data.exist_days == 0) {
                for (let i = 0; i < res.data.data.records.length; i++) {
                    if (res.data.data.records[i].profile_picture_representative == null) {
                        res.data.data.records[i].profile_picture_representative = noImage;
                    } else {
                        res.data.data.records[i].profile_picture_representative = '../../storage/' + deleteBackSlash(res.data.data.records[i].profile_picture_representative);
                    }
                }
                setRecords(prevArray => prevArray.concat(res.data.data.records));
                setCurrentPage(currentPage + 1);
                setIsFetching(false);
            } else {
                setHasMore(false);
            }
        })
    }

    const groupedData = records.reduce((acc, curr) => {
        const date = curr.created_at;
        if (!acc[date]) {
          acc[date] = [];
        }
        acc[date].push(curr);
        return acc;
      }, {});

    const dates = Object.keys(groupedData);

    function openProfileCard(item) {
        if (item.is_match) {
            setProfileCardUserId(item.to_user_id);
            setIsOpenProfileCard(true); 
        } else {
            return;
        }
    }

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    };

    const pictureFrameStyle = {
        'position': 'relative',
        'z-index': '0',
        width: '120px',
        height: '150px'
    }

    const resultStyle = {
        'z-index': 20,
        top: '120px',
        position: 'absolute',
    }

    if (!isOpenProfileCard) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <InfiniteScroll
                        pageStart={0}
                        loadMore={getMatchHistory}
                        hasMore={!isFetching && hasMore}
                        useWindow={false}>
                             {dates.map((date, index) => (
                                <div key={index}>
                                    <h3>{date}</h3>
                                    <div className="images" style={{display: 'flex'}}>
                                        {groupedData[date].map((item, i) => (
                                            <div style={pictureFrameStyle}>
                                                <img key={i} src={item.profile_picture_representative + "?" + dateCash} 
                                                    style={{width: '120px', cursor: item.is_match ? 'pointer' : 'default', height: 'auto', 'z-index': '20'}} 
                                                    onClick={() => openProfileCard(item)}
                                                />
                                                <div style={resultStyle}>
                                                    <MatchResult action={item.action} is_match={item.is_match}></MatchResult>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            ))}
                    </InfiniteScroll>
                </div>
            </div>
        )
    } else if (isOpenProfileCard) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <CommonProfileCard isOpenProfileCard={isOpenProfileCard} 
                        setIsOpenProfileCard={setIsOpenProfileCard} 
                        user_id={profileCardUserId} >
                    </CommonProfileCard>
                </div>
            </div>
        )
    }
}

export default History;
