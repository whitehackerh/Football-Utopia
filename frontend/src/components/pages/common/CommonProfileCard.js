import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { withTokenRequest, requestHeaders } from '../../../http';
import Button from "@mui/material/Button";
import { deleteBackSlash } from '../../../utils/function';
import France from "../../../assets/img/national flags/France.png";
import Germany from "../../../assets/img/national flags/Germany.png";
import Italy from "../../../assets/img/national flags/Italy.png";
import Spain from "../../../assets/img/national flags/Spain.png";
import UK from "../../../assets/img/national flags/UK.png";
import Star from '../../../assets/img/icons/star.png'
import StarDisabled from '../../../assets/img/icons/starDisabled.png'
import Message from '../../../assets/img/icons/message.png'
import { IconButton } from '@mui/material';

const CommonProfileCard = (props) => {
    const [profile, setProfile] = useState(null);
    const [canLike, setCanLike] = useState(null);
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    const date = Date.now();
    const navigate = useNavigate();

    useEffect(() => {
        getProfile();
    }, []);

    function getProfile() {
        withTokenRequest.post('/getUserProfileForCommonCard', {
            login_user_id: localStorage.getItem('user_id'),
            other_user_id: props.user_id
        }, {
            headers: requestHeaders
        }).then((res) => {
            setProfile(res.data.data.profile);
            setCanLike(res.data.data.can_like);
        })
    }

    function showProfilePictureOriginal(pass) {
        window.open('../../storage/' + deleteBackSlash(pass));
    }
    
    function closeProfileCard() {
        props.setIsOpenProfileCard(false);
        if (props.needCloseFunction) {
            switch (props.closeFuncName) {
                case 'closeProfileCardOnHistory': 
                    props.closeFunction();
                    break;
                default:
                    break;
            }
        }
    }

    function sendLike() {
        setCanLike(false);
        withTokenRequest.post('/sendLike', {
            sender_id: localStorage.getItem('user_id'),
            recipient_id: profile.user_id
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.successful == 'failure') {
                setCanLike(true);
            }
        })
    }

    const transitionToMessage = () => {
        let targetPicture = null;
        if (profile.profile_pictures.cropped_1) {
            targetPicture = profile.profile_pictures.cropped_1;
        } else if (profile.profile_pictures.cropped_2) {
            targetPicture = profile.profile_pictures.cropped_2;
        } else if (profile.profile_pictures.cropped_3) {
            targetPicture = profile.profile_pictures.cropped_3;
        }
        if (props.url == 'directMessage') {
            props.clickMessageFunc(true, profile.user_id, profile.name, '../../storage/' + deleteBackSlash(targetPicture) + '?' + date);
        } else {
            navigate('/directMessage', {state: {user_id: profile.user_id, name: profile.name, picture: targetPicture}});
        }
    }

    const cardStyle = {
        border: 'solid black',
        margin: '0 auto',
        width: '540px',
        'overflow-y': 'auto',
        'max-height': '90%'
    };

    const pictureStyle = {
        float: 'left',
        width: '150px',
        cursor: 'pointer'
    }

    const nationalFragStyle = {
        width: '25px'
    }

    const itemFontStyle = {
        'font-size': '20px',
        'margin-left': '10px'
    }

    const textFontStyle = {
        'font-size': '20px',
        'font-weight': 'bold',
        'margin-left': '10px'
    }

    const textAreaStyle = {
        'white-space': 'pre-line',
        'font-size': '20px',
        'font-weight': 'bold',
        'margin-left': '10px'
    }

    const iconsStyle = {
        width: '80px',
        height: '80px'
    }

    const floatTextStyle = {
        'font-size': '20px',
        'font-weight': 'bold',
        'margin-left': '10px'
    }
    let back = '';
    if (!props.noDispBack) {
        back = (
            <>
                <Button onClick={closeProfileCard}> ← Back</Button>
            </>
        );
    }

    let picture1 = '';
    let picture1Src = '';
    let picture2 = '';
    let picture2Src = '';
    let picture3 = '';
    let picture3Src = '';
    let nationality = '';
    let like = '';
    let lookingFor = '';
    let aboutMe = '';
    let playingExperience = '';
    let favoritePart = '';
    let favoriteLeagues = '';
    let favoriteClubteams = '';
    let favoritePlayers = '';
    let favoriteCoaches = '';
    let favoritePositions = '';
    let favoriteFootballGame = '';
    let genderColor = '';
    let gender = '';
    if (profile != null) {
        if (profile.profile_pictures.cropped_1) {
            picture1Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_1);
            picture1 = (
                <>
                    <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_1)}></img>
                </>
            );
        } else if (!profile.profile_pictures.cropped_1 && profile.profile_pictures.cropped_2) {
            picture1Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_2);
            picture1 = (
                <>
                    <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_2)}></img>
                </>
            );
        } else if (!profile.profile_pictures.cropped_1 && !profile.profile_pictures.cropped_2 && profile.profile_pictures.cropped_3) {
            picture1Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_3);
            picture1 = (
                <>
                    <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_3)}></img>
                </>
            );
        }
        if (profile.profile_pictures.cropped_1 && profile.profile_pictures.cropped_2) {
            picture2Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_2);
            picture2 = (
                <>
                    <img src={picture2Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_2)}></img>
                </>
            );
        } else if (profile.profile_pictures.cropped_1 && !profile.profile_pictures.cropped_2 && profile.profile_pictures.cropped_3) {
            picture2Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_3);
            picture2 = (
                <>
                    <img src={picture2Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_3)}></img>
                </>
            );
        }
        if (profile.profile_pictures.cropped_1 && profile.profile_pictures.cropped_2 && profile.profile_pictures.cropped_3) {
            picture3Src = '../../storage/' + deleteBackSlash(profile.profile_pictures.cropped_3);
            picture3 = (
                <>
                    <img src={picture3Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(profile.profile_pictures.original_3)}></img>
                </>
            );
        }

        let nationalFlagPath = '';
        switch (profile.nationality.name) {
            case 'France':
                nationalFlagPath = France;
                break;
            case 'Germany':
                nationalFlagPath = Germany;
                break;
            case 'Italy':
                nationalFlagPath = Italy;
                break;
            case 'Spain':
                nationalFlagPath = Spain;
                break;
            case 'UK':
                nationalFlagPath = UK;
                break;
            default:
                break;
        }
        nationality = (
            <>
                <div style={textFontStyle}>
                    <img src={nationalFlagPath} alt='picture' style={nationalFragStyle}></img>
                    &nbsp;{profile.nationality.name}
                </div>
            </>
        );

        if (canLike) {
            like = (
                <>
                    <IconButton style={{'margin-left': '160px'}} onClick={sendLike}><img src={Star} style={iconsStyle}></img></IconButton>
                </>
            );
        } else {
            like = (
                <>
                    <IconButton style={{'margin-left': '160px'}} disabled={true}><img src={StarDisabled} style={iconsStyle}></img></IconButton>
                </>
            );
        }
        
        if (profile.looking_for.id) {
            lookingFor = (
                <>
                    <div className="looking_for">
                        <div style={itemFontStyle}>Looking For</div>
                        <div style={textFontStyle}>{profile.looking_for.name}</div>
                    </div>
                </>
            );
        }

        if (profile.about_me) {
            aboutMe = (
                <>
                    <br></br>
                    <div className="about_me">
                        <div style={itemFontStyle}>About Me</div>
                        <div style={textAreaStyle}>{profile.about_me}</div>
                    </div>
                </> 
            );
        }

        if (profile.playing_experience != null) {
            playingExperience = (
                <>
                    <br></br>
                    <div className="playing_experience">
                        <div style={itemFontStyle}>Playing Experience</div>
                        <div style={textFontStyle}>{profile.playing_experience}&nbsp;years</div>
                    </div>
                </> 
            );
        }

        if (profile.favorite_part.id) {
            favoritePart = (
                <>
                    <br></br>
                    <div className="favorite_part">
                        <div style={itemFontStyle}>Favorite Part</div>
                        <div style={textFontStyle}>{profile.favorite_part.name}</div>
                    </div>
                </> 
            );
        }

        let secondFavoriteLeague = null;
        if (profile.favorite_leagues.second_favorite_league.id) {
            secondFavoriteLeague = (
                <>
                    <div style={floatTextStyle}>2.&nbsp;{profile.favorite_leagues.second_favorite_league.name}</div>
                </>
            )
        }
        let thirdFavoriteLeague = null;
        if (profile.favorite_leagues.third_favorite_league.id) {
            thirdFavoriteLeague = (
                <>
                    <div style={floatTextStyle}>3.&nbsp;{profile.favorite_leagues.third_favorite_league.name}</div>
                </>
            )
        }
        if (profile.favorite_leagues.favorite_league.id) {
            favoriteLeagues = (
                <>
                    <br></br>
                    <div className="favorite_leagues">
                        <div style={itemFontStyle}>Favorite Leagues</div>
                        <div style={floatTextStyle}>1.&nbsp;{profile.favorite_leagues.favorite_league.name}</div>
                        {secondFavoriteLeague}
                        {thirdFavoriteLeague}
                    </div>
                </>
            )
        }

        let secondFavoriteClubteam = null;
        if (profile.favorite_clubteams.second_favorite_clubteam.id) {
            secondFavoriteClubteam = (
                <>
                    <div style={floatTextStyle}>2.&nbsp;{profile.favorite_clubteams.second_favorite_clubteam.name}</div>
                </>
            )
        }
        let thirdFavoriteClubteam = null;
        if (profile.favorite_clubteams.third_favorite_clubteam.id) {
            thirdFavoriteClubteam = (
                <>
                    <div style={floatTextStyle}>3.&nbsp;{profile.favorite_clubteams.third_favorite_clubteam.name}</div>
                </>
            )
        }
        if (profile.favorite_clubteams.favorite_clubteam.id) {
            favoriteClubteams = (
                <>
                    <br></br>
                    <div className="favorite_clubteams" style={{clear: 'both'}}>
                        <div style={itemFontStyle}>Favorite Clubteams</div>
                        <div style={floatTextStyle}>1.&nbsp;{profile.favorite_clubteams.favorite_clubteam.name}</div>
                        {secondFavoriteClubteam}
                        {thirdFavoriteClubteam}
                    </div>
                </>
            )
        }

        let secondFavoritePlayer = null;
        if (profile.favorite_players.second_favorite_player.id) {
            secondFavoritePlayer = (
                <>
                    <div style={floatTextStyle}>2.&nbsp;{profile.favorite_players.second_favorite_player.name}</div>
                </>
            )
        }
        let thirdFavoritePlayer = null;
        if (profile.favorite_players.third_favorite_player.id) {
            thirdFavoritePlayer = (
                <>
                    <div style={floatTextStyle}>3.&nbsp;{profile.favorite_players.third_favorite_player.name}</div>
                </>
            )
        }
        if (profile.favorite_players.favorite_player.id) {
            favoritePlayers = (
                <>
                    <br></br>
                    <div className="favorite_players" style={{clear: 'both'}}>
                        <div style={itemFontStyle}>Favorite Players</div>
                        <div style={floatTextStyle}>1.&nbsp;{profile.favorite_players.favorite_player.name}</div>
                        {secondFavoritePlayer}
                        {thirdFavoritePlayer}
                    </div>
                </>
            )
        }

        let secondFavoriteCoach = null;
        if (profile.favorite_coaches.second_favorite_coach.id) {
            secondFavoriteCoach = (
                <>
                    <div style={floatTextStyle}>2.&nbsp;{profile.favorite_coaches.second_favorite_coach.name}</div>
                </>
            )
        }
        let thirdFavoriteCoach = null;
        if (profile.favorite_coaches.third_favorite_coach.id) {
            thirdFavoriteCoach = (
                <>
                    <div style={floatTextStyle}>3.&nbsp;{profile.favorite_coaches.third_favorite_coach.name}</div>
                </>
            )
        }
        if (profile.favorite_coaches.favorite_coach.id) {
            favoriteCoaches = (
                <>
                    <br></br>
                    <div className="favorite_coaches" style={{clear: 'both'}}>
                        <div style={itemFontStyle}>Favorite Coaches</div>
                        <div style={floatTextStyle}>1.&nbsp;{profile.favorite_coaches.favorite_coach.name}</div>
                        {secondFavoriteCoach}
                        {thirdFavoriteCoach}
                    </div>
                </>
            )
        }

        let secondFavoritePosition = null;
        if (profile.favorite_positions.second_favorite_position.id) {
            secondFavoritePosition = (
                <>
                    <div style={floatTextStyle}>2.&nbsp;{profile.favorite_positions.second_favorite_position.name}</div>
                </>
            )
        }
        let thirdFavoritePosition = null;
        if (profile.favorite_positions.third_favorite_position.id) {
            thirdFavoritePosition = (
                <>
                    <div style={floatTextStyle}>3.&nbsp;{profile.favorite_positions.third_favorite_position.name}</div>
                </>
            )
        }
        if (profile.favorite_positions.favorite_position.id) {
            favoritePositions = (
                <>
                    <br></br>
                    <div className="favorite_positions" style={{clear: 'both'}}>
                        <div style={itemFontStyle}>Favorite Positions</div>
                        <div style={floatTextStyle}>1.&nbsp;{profile.favorite_positions.favorite_position.name}</div>
                        {secondFavoritePosition}
                        {thirdFavoritePosition}
                    </div>
                </>
            )
        }

        if (profile.favorite_football_game.id) {
            favoriteFootballGame = (
                <>
                    <br></br>
                    <div className="favorite_football_game" style={{clear: 'both'}}>
                        <div style={itemFontStyle}>Favorite Football Game</div>
                        <div style={floatTextStyle}>{profile.favorite_football_game.name}</div>
                    </div>
                </>
            )
        }

        if (profile.gender.id == 1) {
            genderColor = 'blue';
            gender = '♂'
        } else if (profile.gender.id == 2) {
            genderColor = 'red';
            gender = '♀';
        }
    }

    if (profile == null) {
        return <></>;
    }

    return (
        <div>
            {props.isOpenProfileCard ? (
                <div>
                    {back}
                    <div className="profileCardContent" style={cardStyle}>
                        <div className="pictures">
                            {picture1}
                            {picture2}
                            {picture3}
                        </div>
                        <br></br><br></br>
                        <div className="basicProfile" style={{clear: 'both'}}>
                            <div style={{'font-size': '30px', 'font-weight': 'bold', 'margin-left': '10px'}}>{profile.name}</div>
                            {nationality}
                            <div>
                                    <div style={{'font-size': '20px', 'font-weight': 'bold', 'color': genderColor, 'float': 'left',  'margin-left': '10px'}}>{gender} </div>
                                    <div style={{'font-size': '20px', 'font-weight': 'bold', 'float': 'left', 'margin-left': '10px'}}>&nbsp;/&nbsp;{profile.age}&nbsp;yo</div>
                            </div>
                        </div>
                        <br></br><br></br><hr></hr>
                        <div className="buttons" style={{clear: 'both'}}>
                            {like}
                            {/* todo onclick move message */}
                            <IconButton onClick={transitionToMessage}><img src={Message} style={iconsStyle}></img></IconButton>
                        </div>
                        <hr style={{clear: 'both'}}></hr><br></br>
                        <div className="detailProfile">
                            {lookingFor}
                            {aboutMe}
                            {playingExperience}
                            {favoritePart}
                            {favoriteLeagues}
                            {favoriteClubteams}
                            {favoritePlayers}
                            {favoriteCoaches}
                            {favoritePositions}
                            {favoriteFootballGame}
                        </div>
                    </div>
                </div>
            ) : (
                <></>
            )}
        </div>
    )
}

export default CommonProfileCard;
