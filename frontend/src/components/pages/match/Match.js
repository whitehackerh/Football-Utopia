import SideBar_Match from './SideBar_Match'; 
import { useEffect, useState } from 'react';
import { withTokenRequest, requestHeaders } from '../../../http';
import moment from 'moment';
import momentTimeZone from 'moment-timezone';
import ReactLoading from 'react-loading';
import { deleteBackSlash, getCookieArray, getCookieArrayValue, getCookieArrayFirstValue, deleteCookieArrayFirstValue, makeCookieArray } from '../../../utils/function';
import heart from "../../../assets/img/icons/heart.png";
import nope from "../../../assets/img/icons/nope.png";
import info from "../../../assets/img/icons/info.png";
import yesStamp from "../../../assets/img/icons/yesStamp.png";
import nopeStamp from "../../../assets/img/icons/nopeStamp.png";
import matchIcon from "../../../assets/img/icons/match.png";
import IconButton from "@mui/material/IconButton";
import MatchModal from './MatchModal';
import ProfileCardModal from './ProfileCardModal';

const Match = () => {
    const moment = require('moment');
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    const [isLoading, setIsLoading] = useState(true);
    const [profile, setProfile] = useState(null);
    const [gender, setGender] = useState(null);
    const [genderColor, setGenderColor] = useState(null);
    const [selfPicture, setSelfPicture] = useState(null);
    const [pictureOfCard, setPictureOfCard] = useState(null);
    const [pictureCropped, setPictureCropped] = useState(null);
    const [pictureCroppedStash, setPictureCroppedStash] = useState(null);
    const [isPictureNull, setIsPictureNull] = useState(false);
    const [isEnd, setIsEnd] = useState(false);
    const [userNotFound, setUserNotFound] = useState(false);
    const [disabled, setDisabled] = useState(true);
    const [yesStampVisible, setYesStampVisible] = useState(false);
    const [nopeStampVisible, setNopeStampVisible] = useState(false);
    const [isOpenMatchModal, setIsOpenMatchModal] = useState(false);
    const [isOpenProfileCardModal, setIsOpenProfileCardModal] = useState(false);
    const date = Date.now();

    useEffect(() => {
        getProfilePictureCropped();
        getUserList();
    }, []);

    function getProfilePictureCropped() {
        withTokenRequest.post('/getProfilePictureCropped', {
            user_id: localStorage.getItem('user_id')
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.profilePictureCropped1) {
                setSelfPicture('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped1));
            } else if (res.data.data.profilePictureCropped2) {
                setSelfPicture('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped2));
            } else if (res.data.data.profilePictureCropped3) {
                setSelfPicture('../../storage/' + deleteBackSlash(res.data.data.profilePictureCropped3));
            }
        });
    }

    function getUserList() {
        let cookies = getCookieArray();
        if (cookies['userListForMatch'] != null && cookies['userListForMatch'] != '' && cookies['userListForMatch'] != '[]') {
            getUserProfile();
            return;
        }
        withTokenRequest.post('/getUserListForMatch', {
            user_id: localStorage.getItem('user_id')
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.supplement == 0) {
                setCookie(res.data.data.user_list);
                getUserProfile();
            } else if (res.data.data.supplement == 1) {
                setPictureOfCard(null);
                setIsPictureNull(true);
                setIsEnd(false);
                setUserNotFound(false);
                setIsLoading(false);
                return;
            } else if (res.data.data.supplement == 2) {
                setPictureOfCard(null);
                setIsPictureNull(false);
                setIsEnd(true);
                setUserNotFound(false);
                setIsLoading(false);
                return;
            } else if (res.data.data.supplement == 3) {
                setPictureOfCard(null);
                setIsPictureNull(false);
                setIsEnd(false);
                setUserNotFound(true);
                setIsLoading(false);
                return;
            }
        });
    }

    function setCookie(userList) {
        let cookies = 'userListForMatch' + '=' + JSON.stringify(userList) + ';';
        cookies += 'path=/ ;';
        let expiryDate = moment().endOf('day').toDate();
        cookies += 'expires=' + expiryDate + ';';
        document.cookie = cookies;
    }

    function getUserProfile() {
        let cookies = getCookieArray();
        let cookie = getCookieArrayValue(cookies['userListForMatch']);
        let targetUserId = getCookieArrayFirstValue(cookie);
        withTokenRequest.post('/getUserProfileForMatch', {
            user_id: targetUserId,
        }, {
            headers: requestHeaders
        }).then((res) => {
            setProfile(res.data.data);
            if (res.data.data.gender.id == 1) {
                setGender('♂');
                setGenderColor('blue');
            } else if (res.data.data.gender.id == 2) {
                setGender('♀');
                setGenderColor('red');
            }
            if (res.data.data.profile_pictures.original_1) {
                setPictureOfCard('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.original_1));
                setPictureCropped('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.cropped_1));
            } else if (res.data.data.profile_pictures.original_2) {
                setPictureOfCard('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.original_2));
                setPictureCropped('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.cropped_2));
            } else {
                setPictureOfCard('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.original_3));
                setPictureCropped('../../storage/' + deleteBackSlash(res.data.data.profile_pictures.cropped_3));
            }
            setYesStampVisible(false);
            setNopeStampVisible(false);
            setIsLoading(false);
            setDisabled(false);
        });
    }

    function setMatchAction(action) {
        setDisabled(true);
        setPictureCroppedStash(pictureCropped);
        if (action == 0) {
            setYesStampVisible(true);
        } else if (action == 1) {
            setNopeStampVisible(true);
        }
        withTokenRequest.post('/setMatchAction', {
            from_user_id: localStorage.getItem('user_id'),
            to_user_id: profile.user_id,
            action: action
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.isMatch == 0) {
                openMatchModal();
            }
            let cookies = getCookieArray();
            document.cookie = 'userListForMatch=; max-age=0';
            let cookie = getCookieArrayValue(cookies['userListForMatch']);
            cookie = deleteCookieArrayFirstValue(cookie);
            if (cookie == -1) {
                getUserList();
            } else {
                cookie = makeCookieArray(cookie);
                cookie = JSON.parse(cookie);
                setCookie(cookie);
                getUserProfile();
            }
        });
    }
    
    function openMatchModal() {
        setIsOpenMatchModal(true);
    }

    function openProfileCardModal() {
        setIsOpenProfileCardModal(true);
    }
    
    // TODO click info icon -> modal
    // function showDetail

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    };

    const frameStyle = {
        'text-align': 'center',
        width: '50%',
        margin: '0 auto'
    }

    const loadingFrameStyle = {
        'text-align': 'center',
        width: '25%',
        margin: '0 auto'
    }

    const loadingStyle = {
        margin: '0 auto'
    }

    const cardFrameStyle = {
        'position': 'relative',
        width: '540px',
        height: '720px',
        'z-index': '0',
        margin: '0 auto'
    };

    const pictureStyle = {
        'object-fit': 'cover',
        width: '540px',
        height: '720px',
        'z-index': '10'
    };

    const stampStyle = {
        'z-index': '20',
        position: 'absolute',
        top: '5px',
        left: '370px',
    }

    const profileStyle = {
        'z-index': '20',
        position: 'absolute',
        color: 'white',
        top: '630px',
        left: '10px',
        'font-weight': 'bold',
    }

    const infoStyle = {
        'z-index': '20',
        position: 'absolute',
        top: '660px',
        left: '480px',
    }

    const infoIconStyle = {
        width: '40px',
        height: '40px'
    }

    const buttonsStyle = {
        margin: '20px'
    };

    const buttonStyle = {
        float: 'left',
        width: '75px',
        height: '75px',
        'margin-left': '75px',
        'margin-right': '75px'
    };

    if (isLoading) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <section className="flex justify-center items-center h-screen" style={loadingFrameStyle}>
                        <div style={loadingStyle}>
                        <ReactLoading
                            type="spin"
                            color="#ebc634"
                            height="50px"
                            width="50px"
                            className="mx-auto"
                            style={loadingStyle}
                        />
                        <p className="text-center mt-3" style={{'font-size': '20px'}}>{'Loading...'}</p>
                        </div>
                    </section>
                </div>
            </div>
        );
    } else if (!isLoading && !isPictureNull && !isEnd && !userNotFound) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <div className="frame" style={frameStyle}>
                        <div className="userCard" style={cardFrameStyle}>
                            <img src={pictureOfCard + "?" + date} alt="picture" style={pictureStyle}>
                            </img><br></br>
                            <div style={stampStyle}>
                                <img src={yesStamp} style={{ visibility: yesStampVisible ? 'visible' : 'hidden', width: '180px'}}></img>
                            </div>
                            <div style={stampStyle}>
                                <img src={nopeStamp} style={{ visibility: nopeStampVisible ? 'visible' : 'hidden', width: '180px'}}></img>
                            </div>
                            <div style={profileStyle}>
                                <div style={{'font-size': '40px'}}>{profile.name}<br></br></div>
                                <div>
                                    <div style={{'font-size': '20px', 'color': genderColor, 'float': 'left'}}>{gender} </div>
                                    <div style={{'font-size': '20px', 'float': 'left'}}>&nbsp;/&nbsp;{profile.age}&nbsp;yo</div>
                                </div>
                            </div>
                            <div style={infoStyle}>
                                <IconButton disabled={disabled}><img src={info} style={infoIconStyle} onClick={openProfileCardModal}></img></IconButton>
                            </div>
                        </div>
                        <div className="buttons" style={buttonsStyle}>
                            <IconButton disabled={disabled} onClick={() => setMatchAction(0)}><img src={heart} style={buttonStyle}></img></IconButton>
                            <IconButton disabled={disabled} onClick={() => setMatchAction(1)}><img src={nope} style={buttonStyle}></img></IconButton>
                        </div>
                    </div>
                </div>
                <MatchModal isOpenMatchModal={isOpenMatchModal} setIsOpenMatchModal={setIsOpenMatchModal} selfPicture={selfPicture} matchIcon={matchIcon} pictureCroppedStash={pictureCroppedStash}/>
                <ProfileCardModal isOpenProfileCardModal={isOpenProfileCardModal} setIsOpenProfileCardModal={setIsOpenProfileCardModal} profile={profile} gender={gender} genderColor={genderColor} />
            </div>
        );
    } else if (!isLoading && isPictureNull && !isEnd && !userNotFound) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <div className="frame" style={frameStyle}>
                        <div style={frameStyle}>
                            You need to register a profile picture.
                        </div>
                    </div>
                </div>
            </div>
        );
    } else if (!isLoading && !isPictureNull && isEnd && !userNotFound) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <div className="frame" style={frameStyle}>
                        <div style={frameStyle}>
                            Today's match is over.
                        </div>
                    </div>
                </div>
            </div>
        );
    } else if (!isLoading && !isPictureNull && !isEnd && userNotFound) {
        return (
            <div>
                <SideBar_Match />
                <div style={mainContents}>
                    <div className="frame" style={frameStyle}>
                        <div style={frameStyle}>
                            Users not found.
                        </div>
                    </div>
                </div>
            </div>
        );
    }
};

export default Match;