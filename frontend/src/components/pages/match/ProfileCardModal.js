import React from 'react';
import { deleteBackSlash } from '../../../utils/function';
import France from "../../../assets/img/national flags/France.png";
import Germany from "../../../assets/img/national flags/Germany.png";
import Italy from "../../../assets/img/national flags/Italy.png";
import Spain from "../../../assets/img/national flags/Spain.png";
import UK from "../../../assets/img/national flags/UK.png";

const ProfileCardModal = (props) => {
    const date = Date.now();

    const overlay = {
        position: "fixed",
        top: 0,
        left: 0,
        width: "100%",
        height: "100%",
        backgroundColor: "rgba(0,0,0,0.5)",
    
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
    };

    const modalContent = {
        background: "white",
        padding: "10px",
        borderRadius: "3px",
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
    }

    const textFontStyle = {
        'font-size': '20px',
        'font-weight': 'bold'
    }

    const textAreaStyle = {
        'white-space': 'pre-line',
        'font-size': '20px',
        'font-weight': 'bold'
    }

    const floatTextStyle = {
        'font-size': '20px',
        'font-weight': 'bold',
    }

    function closeProfileCardModal(event) {
        const target = event.target.className;
        if (target === "profileCardModal") {
            props.setIsOpenProfileCardModal(false);
        }
    }

    function showProfilePictureOriginal(pass) {
        window.open('../../storage/' + deleteBackSlash(pass));
    }

    let picture1 = '';
    let picture1Src = '';
    let picture2 = '';
    let picture2Src = '';
    let picture3 = '';
    let picture3Src = '';
    if (props.profile.profile_pictures.cropped_1) {
        picture1Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_1);
        picture1 = (
            <>
                <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_1)}></img>
            </>
        );
    } else if (!props.profile.profile_pictures.cropped_1 && props.profile.profile_pictures.cropped_2) {
        picture1Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_2);
        picture1 = (
            <>
                <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_2)}></img>
            </>
        );
    } else if (!props.profile.profile_pictures.cropped_1 && !props.profile.profile_pictures.cropped_2 && props.profile.profile_pictures.cropped_3) {
        picture1Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_3);
        picture1 = (
            <>
                <img src={picture1Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_3)}></img>
            </>
        );
    }
    if (props.profile.profile_pictures.cropped_1 && props.profile.profile_pictures.cropped_2) {
        picture2Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_2);
        picture2 = (
            <>
                <img src={picture2Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_2)}></img>
            </>
        );
    } else if (props.profile.profile_pictures.cropped_1 && !props.profile.profile_pictures.cropped_2 && props.profile.profile_pictures.cropped_3) {
        picture2Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_3);
        picture2 = (
            <>
                <img src={picture2Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_3)}></img>
            </>
        );
    }
    if (props.profile.profile_pictures.cropped_1 && props.profile.profile_pictures.cropped_2 && props.profile.profile_pictures.cropped_3) {
        picture3Src = '../../storage/' + deleteBackSlash(props.profile.profile_pictures.cropped_3);
        picture3 = (
            <>
                <img src={picture3Src + '?' + date} alt='picture' style={pictureStyle} onClick={() => showProfilePictureOriginal(props.profile.profile_pictures.original_3)}></img>
            </>
        );
    }

    let nationality = '';
    let nationalFlagPath = '';
    switch (props.profile.nationality.name) {
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
                &nbsp;{props.profile.nationality.name}
            </div>
        </>
    );

    let lookingFor = null;
    if (props.profile.looking_for.id) {
        lookingFor = (
            <>
                <div className="looking_for">
                    <div style={itemFontStyle}>Looking For</div>
                    <div style={textFontStyle}>{props.profile.looking_for.name}</div>
                </div>
            </>
        );
    }

    let aboutMe = null;
    if (props.profile.about_me) {
        aboutMe = (
            <>
                <br></br>
                <div className="about_me">
                    <div style={itemFontStyle}>About Me</div>
                    <div style={textAreaStyle}>{props.profile.about_me}</div>
                </div>
            </> 
        );
    }

    let playingExperience = null;
    if (props.profile.playing_experience != null) {
        playingExperience = (
            <>
                <br></br>
                <div className="playing_experience">
                    <div style={itemFontStyle}>Playing Experience</div>
                    <div style={textFontStyle}>{props.profile.playing_experience}&nbsp;years</div>
                </div>
            </> 
        );
    }

    let favoritePart = null;
    if (props.profile.favorite_part.id) {
        favoritePart = (
            <>
                <br></br>
                <div className="favorite_part">
                    <div style={itemFontStyle}>Favorite Part</div>
                    <div style={textFontStyle}>{props.profile.favorite_part.name}</div>
                </div>
            </> 
        );
    }

    let secondFavoriteLeague = null;
    if (props.profile.favorite_leagues.second_favorite_league.id) {
        secondFavoriteLeague = (
            <>
                <div style={floatTextStyle}>2.&nbsp;{props.profile.favorite_leagues.second_favorite_league.name}</div>
            </>
        )
    }
    let thirdFavoriteLeague = null;
    if (props.profile.favorite_leagues.third_favorite_league.id) {
        thirdFavoriteLeague = (
            <>
                <div style={floatTextStyle}>3.&nbsp;{props.profile.favorite_leagues.third_favorite_league.name}</div>
            </>
        )
    }
    let favoriteLeagues = null;
    if (props.profile.favorite_leagues.favorite_league.id) {
        favoriteLeagues = (
            <>
                <br></br>
                <div className="favorite_leagues">
                    <div style={itemFontStyle}>Favorite Leagues</div>
                    <div style={floatTextStyle}>1.&nbsp;{props.profile.favorite_leagues.favorite_league.name}</div>
                    {secondFavoriteLeague}
                    {thirdFavoriteLeague}
                </div>
            </>
        )
    }

    let secondFavoriteClubteam = null;
    if (props.profile.favorite_clubteams.second_favorite_clubteam.id) {
        secondFavoriteClubteam = (
            <>
                <div style={floatTextStyle}>2.&nbsp;{props.profile.favorite_clubteams.second_favorite_clubteam.name}</div>
            </>
        )
    }
    let thirdFavoriteClubteam = null;
    if (props.profile.favorite_clubteams.third_favorite_clubteam.id) {
        thirdFavoriteClubteam = (
            <>
                <div style={floatTextStyle}>3.&nbsp;{props.profile.favorite_clubteams.third_favorite_clubteam.name}</div>
            </>
        )
    }
    let favoriteClubteams = null;
    if (props.profile.favorite_clubteams.favorite_clubteam.id) {
        favoriteClubteams = (
            <>
                <br></br>
                <div className="favorite_clubteams" style={{clear: 'both'}}>
                    <div style={itemFontStyle}>Favorite Clubteams</div>
                    <div style={floatTextStyle}>1.&nbsp;{props.profile.favorite_clubteams.favorite_clubteam.name}</div>
                    {secondFavoriteClubteam}
                    {thirdFavoriteClubteam}
                </div>
            </>
        )
    }

    let secondFavoritePlayer = null;
    if (props.profile.favorite_players.second_favorite_player.id) {
        secondFavoritePlayer = (
            <>
                <div style={floatTextStyle}>2.&nbsp;{props.profile.favorite_players.second_favorite_player.name}</div>
            </>
        )
    }
    let thirdFavoritePlayer = null;
    if (props.profile.favorite_players.third_favorite_player.id) {
        thirdFavoritePlayer = (
            <>
                <div style={floatTextStyle}>3.&nbsp;{props.profile.favorite_players.third_favorite_player.name}</div>
            </>
        )
    }
    let favoritePlayers = null;
    if (props.profile.favorite_players.favorite_player.id) {
        favoritePlayers = (
            <>
                <br></br>
                <div className="favorite_players" style={{clear: 'both'}}>
                    <div style={itemFontStyle}>Favorite Players</div>
                    <div style={floatTextStyle}>1.&nbsp;{props.profile.favorite_players.favorite_player.name}</div>
                    {secondFavoritePlayer}
                    {thirdFavoritePlayer}
                </div>
            </>
        )
    }

    let secondFavoriteCoach = null;
    if (props.profile.favorite_coaches.second_favorite_coach.id) {
        secondFavoriteCoach = (
            <>
                <div style={floatTextStyle}>2.&nbsp;{props.profile.favorite_coaches.second_favorite_coach.name}</div>
            </>
        )
    }
    let thirdFavoriteCoach = null;
    if (props.profile.favorite_coaches.third_favorite_coach.id) {
        thirdFavoriteCoach = (
            <>
                <div style={floatTextStyle}>3.&nbsp;{props.profile.favorite_coaches.third_favorite_coach.name}</div>
            </>
        )
    }
    let favoriteCoaches = null;
    if (props.profile.favorite_coaches.favorite_coach.id) {
        favoriteCoaches = (
            <>
                <br></br>
                <div className="favorite_coaches" style={{clear: 'both'}}>
                    <div style={itemFontStyle}>Favorite Coaches</div>
                    <div style={floatTextStyle}>1.&nbsp;{props.profile.favorite_coaches.favorite_coach.name}</div>
                    {secondFavoriteCoach}
                    {thirdFavoriteCoach}
                </div>
            </>
        )
    }

    let secondFavoritePosition = null;
    if (props.profile.favorite_positions.second_favorite_position.id) {
        secondFavoritePosition = (
            <>
                <div style={floatTextStyle}>2.&nbsp;{props.profile.favorite_positions.second_favorite_position.name}</div>
            </>
        )
    }
    let thirdFavoritePosition = null;
    if (props.profile.favorite_positions.third_favorite_position.id) {
        thirdFavoritePosition = (
            <>
                <div style={floatTextStyle}>3.&nbsp;{props.profile.favorite_positions.third_favorite_position.name}</div>
            </>
        )
    }
    let favoritePositions = null;
    if (props.profile.favorite_positions.favorite_position.id) {
        favoritePositions = (
            <>
                <br></br>
                <div className="favorite_positions" style={{clear: 'both'}}>
                    <div style={itemFontStyle}>Favorite Positions</div>
                    <div style={floatTextStyle}>1.&nbsp;{props.profile.favorite_positions.favorite_position.name}</div>
                    {secondFavoritePosition}
                    {thirdFavoritePosition}
                </div>
            </>
        )
    }

    let favoriteFootballGame = null;
    if (props.profile.favorite_football_game.id) {
        favoriteFootballGame = (
            <>
                <br></br>
                <div className="favorite_football_game" style={{clear: 'both'}}>
                    <div style={itemFontStyle}>Favorite Football Game</div>
                    <div style={floatTextStyle}>{props.profile.favorite_football_game.name}</div>
                </div>
            </>
        )
    }

    return (
        <div>
            {props.isOpenProfileCardModal ? (
                <div className="profileCardModal" onClick={event => closeProfileCardModal(event)} style={overlay}>
                    <div className="profileCardContent" style={modalContent}>
                        <div className="pictures" /*style={picturesBlockStyle}*/>
                            {picture1}
                            {picture2}
                            {picture3}
                        </div>
                        <div className="basicProfile" style={{clear: 'both'}}>
                            <div style={{'font-size': '30px', 'font-weight': 'bold'}}>{props.profile.name}</div>
                            {nationality}
                            <div>
                                    <div style={{'font-size': '20px', 'font-weight': 'bold', 'color': props.genderColor, 'float': 'left'}}>{props.gender} </div>
                                    <div style={{'font-size': '20px', 'font-weight': 'bold', 'float': 'left'}}>&nbsp;/&nbsp;{props.profile.age}&nbsp;yo</div>
                            </div>
                        </div>
                        <br></br><br></br><br></br>
                        <div className="detailProfile" style={{clear: 'both'}}>
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

export default ProfileCardModal;