

import { useState, useEffect } from 'react';
import useInterval from 'use-interval';
import InifiniteScroll from 'react-infinite-scroller';
import { withTokenRequest, requestHeaders } from '../../../http';
import { deleteBackSlash } from '../../../utils/function';
import CommonProfileCard from '../common/CommonProfileCard'; 
import noImage from "../../../assets/img/no image/noimage.png"

const Notifications = () => {
    const [firstRequest, setFirstRequest] = useState(true);
    const [displayedLatestId, setDisplayedLatestId] = useState(null);
    const [displayedOldestId, setDisplayedOldestId] = useState(null);
    const [records, setRecords] = useState([]);
    const [unreadRecords, setUnreadRecords] = useState([]);
    const [isFetching, setIsFetching] = useState(false);
    const [hasMore, setHasMore] = useState(true);
    const [profileCardUserId, setProfileCardUserId] = useState(null);
    const [isOpenProfileCard, setIsOpenProfileCard] = useState(false);
    const [existNewNotifications, setExistNewNotifications] = useState(false);
    const dateCash = Date.now();
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;

    useInterval(() => {
        if (!firstRequest) {
            withTokenRequest.post('/getNotifications', {
                user_id: localStorage.getItem('user_id'),
                first_request: false,
                displayed_latest_id: displayedLatestId,
                displayed_oldest_id: null
            }, {
                headers: requestHeaders
            }).then((res) => {
                if (res.data.data.notifications.length) {
                    res.data.data.notifications.forEach(function(record) {
                        if (record.profile_picture) {
                            record.profile_picture = '../../storage/' + deleteBackSlash(record.profile_picture) + "?" + dateCash;
                        } else {
                            record.profile_picture = noImage;
                        }
                    })
                    if (res.data.data.notifications.length != unreadRecords.length) {
                        setUnreadRecords(res.data.data.notifications);
                        setExistNewNotifications(true);
                    }
                }
            });
        }
    }, 5000);

    const addRecords = (data, first) => {
        data.notifications.forEach(function(record) {
            if (record.profile_picture) {
                record.profile_picture = '../../storage/' + deleteBackSlash(record.profile_picture) + "?" + dateCash;
            } else {
                record.profile_picture = noImage;
            }
        })
        if (data.notifications.length) {
            setDisplayedOldestId(data.notifications[data.notifications.length - 1].id);
        }
        setRecords(prevArray => prevArray.concat(data.notifications));
        if (data.notifications.length != 10) {
            setHasMore(false);
        }
        setIsFetching(false);
        if (first && data.notifications[0].read == 0) {
            setReadNotifications(data.notifications[0].id);
        }
    }

    const getNotificationsFirst = async () => {
        setIsFetching(true);
        withTokenRequest.post('/getNotifications', {
            user_id: localStorage.getItem('user_id'),
            first_request: true,
            displayed_latest_id: null,
            displayed_oldest_id: null
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.notifications.length) {
                setDisplayedLatestId(res.data.data.notifications[0].id);
            }
            setFirstRequest(false);
            addRecords(res.data.data, true);
        });
    }

    const getNotifications = async () => {
        setIsFetching(true);
        if (firstRequest) {
            getNotificationsFirst();
        } else {
            withTokenRequest.post('/getNotifications', {
                user_id: localStorage.getItem('user_id'),
                first_request: false,
                displayed_latest_id: null,
                displayed_oldest_id: displayedOldestId
            }, {
                headers: requestHeaders
            }).then((res) => {
                addRecords(res.data.data, false);
            });
        }
    }

    const setReadNotifications = async (id) => {
        withTokenRequest.post('/setReadNotifications', {
            user_id: localStorage.getItem('user_id'),
            latest_to_read_id: id
        }, {
            headers: requestHeaders
        }).then(() => {

        })
    };

    const updateRecords = async () => {
        setRecords((prevRecords) => [...unreadRecords, ...prevRecords]);
        setDisplayedLatestId(unreadRecords[0].id);
        setReadNotifications(unreadRecords[0].id);
        setExistNewNotifications(false);
        setUnreadRecords([]);
    }

    function openProfileCard(record) {
        setProfileCardUserId(record.sender_id);
        setIsOpenProfileCard(true);
    }

    const mainContents = {
        border: 'solid black',
        margin: '0 auto',
        width: '600px',
        'overflow-y': 'auto',
        'max-height': '90%',
        'margin-top': '20px'
    }

    const profileCardFrame = {
        margin: '0 auto',
        width: '1000px',
        'overflow-y': 'auto',
        'max-height': '90%',
    }

    const notificationStyle = {
        cursol: 'pointer',
        display: 'flex'
    }

    const pictureStyle = {
        width: '100px',
        height: 'auto'
    }

    const textStyle = {
        'margin-left': '10px',
        'font-weight': 'bold'
    }

    const newNotificationsStyle = {
        'display': existNewNotifications ? 'block' : 'none',
        'text-align': 'center',
        'font-weight': 'bold',
        'color': 'blue',
        'margin-bottom': '10px',
        'background-color': '#C0C0C0',
        'font-size': '20px'
    }

    if (!isOpenProfileCard) {
        return (
            <div>
                <div style={mainContents}>
                    <InifiniteScroll
                        loadMore={getNotifications}
                        hasMore={!isFetching && hasMore}
                        useWindow={false}>
                            <h3 style={newNotificationsStyle} onClick={() => updateRecords()}>New Notifications</h3>
                            {records.map((record) => (
                                <div key={record.id}>
                                    <div
                                        className="notification"
                                        style={notificationStyle}
                                        onClick={() => openProfileCard(record)}
                                    >
                                        <img src={record.profile_picture} style={pictureStyle} alt="Profile"></img>
                                        <div style={textStyle}>{record.message}</div>
                                    </div>
                                    <hr></hr>
                                </div>
                            ))}
                    </InifiniteScroll>
                </div>
            </div>
        );
    } else if (isOpenProfileCard) {
        return (
            <div>
                <div style={profileCardFrame}>
                    <CommonProfileCard isOpenProfileCard={isOpenProfileCard} 
                        setIsOpenProfileCard={setIsOpenProfileCard} 
                        user_id={profileCardUserId} >
                    </CommonProfileCard>
                </div>
            </div>
        )
    }
}

export default Notifications;