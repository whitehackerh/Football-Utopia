import SideBar_AccountSettings from './SideBar_AccountSettings'; 
import { useEffect, useState } from 'react';
import { withTokenRequest, requestHeaders } from '../../../http';
import { noTokenRequest } from '../../../http';
import TextField from '@mui/material/TextField';
import Autocomplete from '@mui/material/Autocomplete';
import { styled, lighten, darken } from '@mui/system';
import TextareaAutosize from '@mui/base/TextareaAutosize';
import Button from "@mui/material/Button";
import { years } from '../../modules/const/years'; 

const DetailProfileSettings = () => {
    const [masterData, setMasterData] = useState(null);
    const [lookingFor, setLookingFor] = useState(null);
    const [favoriteLeagues, setFavoriteLeagues] = useState(null);
    const [favoriteClubteams, setFavoriteClubteams] = useState(null);
    const [favoritePlayers, setFavoritePlayers] = useState(null);
    const [favoriteCoaches, setFavoriteCoaches] = useState(null);
    const [favoritePositions, setFavoritePositions] = useState(null);
    const [favoritePart, setFavoritePart] = useState(null);
    const [favoriteFootballGame, setFavoriteFootballGame] = useState(null);
    const [playingExperience, setPlayingExperience] = useState(null);
    const [aboutMe, setAboutMe] = useState(null);
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;

    useEffect(() => {
        getMasterData();
        getUserDetailProfile();
    }, []);

    function getMasterData() {
        noTokenRequest.get('/getMasterDataForProfile', {
        }).then((res) => {
            setMasterData(res.data.data);
        });
    }

    function getUserDetailProfile() {
        withTokenRequest.post('/getUserDetailProfile', {
            user_id: localStorage.getItem('user_id')
        }, {
            headers: requestHeaders
        }).then((res) => {
            setLookingFor({
                ...lookingFor,
                id: res.data.data.looking_for.id ? res.data.data.looking_for.id : null,
                name: res.data.data.looking_for.name ? res.data.data.looking_for.name : ''
            });
            setFavoriteLeagues({
                ...favoriteLeagues,
                favorite_league: {
                    id: res.data.data.favorite_leagues.favorite_league.id ? res.data.data.favorite_leagues.favorite_league.id : null,
                    name: res.data.data.favorite_leagues.favorite_league.name ? res.data.data.favorite_leagues.favorite_league.name : ''
                },
                second_favorite_league: {
                    id: res.data.data.favorite_leagues.second_favorite_league.id ? res.data.data.favorite_leagues.second_favorite_league.id : null,
                    name: res.data.data.favorite_leagues.second_favorite_league.name ? res.data.data.favorite_leagues.second_favorite_league.name : ''
                },
                third_favorite_league: {
                    id: res.data.data.favorite_leagues.third_favorite_league.id ? res.data.data.favorite_leagues.third_favorite_league.id : null,
                    name: res.data.data.favorite_leagues.third_favorite_league.name ? res.data.data.favorite_leagues.third_favorite_league.name : ''
                }
            });
            setFavoriteClubteams({
                ...favoriteClubteams,
                favorite_clubteam: {
                    id: res.data.data.favorite_clubteams.favorite_clubteam.id ? res.data.data.favorite_clubteams.favorite_clubteam.id : null,
                    name: res.data.data.favorite_clubteams.favorite_clubteam.name ? res.data.data.favorite_clubteams.favorite_clubteam.name : ''
                },
                second_favorite_clubteam: {
                    id: res.data.data.favorite_clubteams.second_favorite_clubteam.id ? res.data.data.favorite_clubteams.second_favorite_clubteam.id : null,
                    name: res.data.data.favorite_clubteams.second_favorite_clubteam.name ? res.data.data.favorite_clubteams.second_favorite_clubteam.name : ''
                },
                third_favorite_clubteam: {
                    id: res.data.data.favorite_clubteams.third_favorite_clubteam.id ? res.data.data.favorite_clubteams.third_favorite_clubteam.id : null,
                    name: res.data.data.favorite_clubteams.third_favorite_clubteam.name ? res.data.data.favorite_clubteams.third_favorite_clubteam.name : ''
                },
            });
            setFavoritePlayers({
                ...favoritePlayers,
                favorite_player: {
                    id: res.data.data.favorite_players.favorite_player.id ? res.data.data.favorite_players.favorite_player.id : null,
                    name: res.data.data.favorite_players.favorite_player.name ? res.data.data.favorite_players.favorite_player.name : '',
                },
                second_favorite_player: {
                    id: res.data.data.favorite_players.second_favorite_player.id ? res.data.data.favorite_players.second_favorite_player.id : null,
                    name: res.data.data.favorite_players.second_favorite_player.name ? res.data.data.favorite_players.second_favorite_player.name : '',
                },
                third_favorite_player: {
                    id: res.data.data.favorite_players.third_favorite_player.id ? res.data.data.favorite_players.third_favorite_player.id : null,
                    name: res.data.data.favorite_players.third_favorite_player.name ? res.data.data.favorite_players.third_favorite_player.name : '',
                }
            });
            setFavoriteCoaches({
                ...favoriteCoaches,
                favorite_coach: {
                    id: res.data.data.favorite_coaches.favorite_coach.id ? res.data.data.favorite_coaches.favorite_coach.id : null,
                    name: res.data.data.favorite_coaches.favorite_coach.name ? res.data.data.favorite_coaches.favorite_coach.name : '',
                },
                second_favorite_coach: {
                    id: res.data.data.favorite_coaches.second_favorite_coach.id ? res.data.data.favorite_coaches.second_favorite_coach.id : null,
                    name: res.data.data.favorite_coaches.second_favorite_coach.name ? res.data.data.favorite_coaches.second_favorite_coach.name : '',
                },
                third_favorite_coach: {
                    id: res.data.data.favorite_coaches.third_favorite_coach.id ? res.data.data.favorite_coaches.third_favorite_coach.id : null,
                    name: res.data.data.favorite_coaches.third_favorite_coach.name ? res.data.data.favorite_coaches.third_favorite_coach.name : '',
                }
            });
            setFavoritePositions({
                ...favoritePositions,
                favorite_position: {
                    id: res.data.data.favorite_positions.favorite_position.id ? res.data.data.favorite_positions.favorite_position.id : null,
                    name: res.data.data.favorite_positions.favorite_position.name ? res.data.data.favorite_positions.favorite_position.name : '',
                },
                second_favorite_position: {
                    id: res.data.data.favorite_positions.second_favorite_position.id ? res.data.data.favorite_positions.second_favorite_position.id : null,
                    name: res.data.data.favorite_positions.second_favorite_position.name ? res.data.data.favorite_positions.second_favorite_position.name : '',
                },
                third_favorite_position: {
                    id: res.data.data.favorite_positions.third_favorite_position.id ? res.data.data.favorite_positions.third_favorite_position.id : null,
                    name: res.data.data.favorite_positions.third_favorite_position.name ? res.data.data.favorite_positions.third_favorite_position.name : '',
                }
            });
            setFavoritePart({
                ...favoritePart,
                id: res.data.data.favorite_part.id ? res.data.data.favorite_part.id : null,
                name: res.data.data.favorite_part.name ? res.data.data.favorite_part.name : '',
            });
            setFavoriteFootballGame({
                ...favoriteFootballGame,
                id: res.data.data.favorite_football_game.id ? res.data.data.favorite_football_game.id : null,
                name: res.data.data.favorite_football_game.name ? res.data.data.favorite_football_game.name : '',
            });
            setPlayingExperience(res.data.data.playing_experience);
            setAboutMe(res.data.data.about_me);
        });
    }

    if (masterData == null || lookingFor == null || favoriteLeagues == null 
        || favoriteClubteams == null || favoritePlayers == null || favoriteCoaches == null  
        || favoritePositions == null || favoritePart == null || favoriteFootballGame == null
    ) {
        return (
            <div></div>
        );
    }

    const GroupHeader = styled('div')(({ theme }) => ({
        position: 'sticky',
        top: '-8px',
        padding: '4px 10px',
        color: '#1976d2',
        backgroundColor:
          theme.palette.mode === 'light'
            ? lighten('#42a5f5', 0.85)
            : darken('#1976d2', 0.8),
    }));

    const clubteamsOptions = masterData.clubteams.map((option) => {
        const category = searchLeague(option.league_id);
        return {
            category: category, ...option
        };
    })

    function searchLeague(league_id) {
        let target = '';
        masterData.leagues.forEach(leagues => {
            if (leagues.id == league_id) {
                target = leagues.name
            }
        });
        return target;
    }

    const playersOptions = masterData.players.map((option) => {
        const category = searchClubteam(option.league_id, option.clubteam_id);
        return {
            category: category, ...option
        };
    });

    function searchClubteam(league_id, clubteam_id) {
        let target = '';
        masterData.clubteams.forEach(clubteams => {
            if (clubteams.league_id == league_id && clubteams.clubteam_id == clubteam_id) {
                target = clubteams.name;
            }
        });
        return target;
    }

    const coachesOptions = masterData.coaches.map((option) => {
        const firstLetter = option.name[0].toUpperCase();
        return {
            firstLetter: /[0-9]/.test(firstLetter) ? '0-9' : firstLetter,
            ...option,
        };
    });

    function handleChange(e, newValue, setterName, setterParams) {
        const target = e.target;
        const value = target.value;
        const name = target.name;
        switch (setterName) {
            case 'setLookingFor':
                setLookingFor({
                    ...lookingFor,
                    id: newValue ? newValue.id : null,
                    name: newValue ? newValue.name : ''
                });
                break;
            case 'setFavoriteLeagues':
                setFavoriteLeagues({
                    ...favoriteLeagues,
                    [setterParams]: {
                        id: newValue ? newValue.id : null,
                        name: newValue ? newValue.name : ''
                    }
                });
                break;
            case 'setFavoriteClubteams':
                setFavoriteClubteams({
                    ...favoriteClubteams,
                    [setterParams]: {
                        id: newValue ? newValue.id : null,
                        name: newValue ? newValue.name : ''
                    }
                });
                break;
            case 'setFavoritePlayers':
                setFavoritePlayers({
                    ...favoritePlayers,
                    [setterParams]: {
                        id: newValue ? newValue.id : null,
                        name: newValue ? newValue.name : ''
                    }
                });
                break;
            case 'setFavoriteCoaches':
                setFavoriteCoaches({
                    ...favoriteCoaches,
                    [setterParams]: {
                        id: newValue ? newValue.id : null,
                        name: newValue ? newValue.name : ''
                    }
                });
                break;
            case 'setFavoritePositions':
                setFavoritePositions({
                    ...favoritePositions,
                    [setterParams]: {
                        id: newValue ? newValue.id : null,
                        name: newValue ? newValue.name : ''
                    }
                });
                break;
            case 'setFavoritePart':
                setFavoritePart({
                    ...favoritePart,
                    id: newValue ? newValue.id : null,
                    name: newValue ? newValue.name : ''
                });
                break;
            case 'setFavoriteFootballGame':
                setFavoriteFootballGame({
                    ...favoriteFootballGame,
                    id: newValue ? newValue.id : null,
                    name: newValue ? newValue.name : ''
                });
                break;
            case 'setPlayingExperience':
                setPlayingExperience(newValue);
                break;
            case 'setAboutMe':
                setAboutMe(value);
                break;
            default:
                break;
        }
    }

    function setUserDetailProfile() {
        withTokenRequest.post('/setUserDetailProfile', {
            user_id: localStorage.getItem('user_id'),
            looking_for: lookingFor.id,
            favorite_leagues: {
                favorite_league: favoriteLeagues.favorite_league.id,
                second_favorite_league: favoriteLeagues.second_favorite_league.id,
                third_favorite_league: favoriteLeagues.third_favorite_league.id,
            },
            favorite_clubteams: {
                favorite_clubteam: favoriteClubteams.favorite_clubteam.id,
                second_favorite_clubteam: favoriteClubteams.second_favorite_clubteam.id,
                third_favorite_clubteam: favoriteClubteams.third_favorite_clubteam.id,
            },
            favorite_players: {
                favorite_player: favoritePlayers.favorite_player.id,
                second_favorite_player: favoritePlayers.second_favorite_player.id,
                third_favorite_player: favoritePlayers.third_favorite_player.id,
            },
            favorite_coaches: {
                favorite_coach: favoriteCoaches.favorite_coach.id,
                second_favorite_coach: favoriteCoaches.second_favorite_coach.id,
                third_favorite_coach: favoriteCoaches.third_favorite_coach.id,
            },
            favorite_positions: {
                favorite_position: favoritePositions.favorite_position.id,
                second_favorite_position: favoritePositions.second_favorite_position.id,
                third_favorite_position: favoritePositions.third_favorite_position.id,
            },
            favorite_part: favoritePart.id,
            favorite_football_game: favoriteFootballGame.id,
            playing_experience: playingExperience,
            about_me: aboutMe
        }, {
            headers: requestHeaders
        })
        .then(() => {
            getUserDetailProfile();
        })
        .catch((error) => {
            console.log(error);
        })
    }

    /** css */
    const mainContents = {
        float: 'left',
        margin: '10px',
        width: 'calc(100% - 362px)'
    }
    const detailForm = {
        margin: "50px"
    }
    const GroupItems = styled('ul')({
        padding: 0,
    });
    const flexValue = {
        display: 'flex',
        margin: '10px'
    }
    const marginRightValue = {
        marginRight: '10px'
    }

    return (
        <div>
            <SideBar_AccountSettings />
            <div style={mainContents}>
                <div style={detailForm}>
                    <div className="lookingFor" style={flexValue}>
                        <Autocomplete
                            id="lookingFor"
                            style={marginRightValue}
                            defaultValue={lookingFor ? lookingFor : ''}
                            options={masterData.looking_for}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Looking for" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setLookingFor', null);}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoriteLeagues" style={flexValue}>
                        <Autocomplete
                            id="favoriteLeague"
                            style={marginRightValue}
                            defaultValue={favoriteLeagues ? favoriteLeagues.favorite_league : ''}
                            options={masterData.leagues}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite League" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteLeagues', 'favorite_league');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="secondfavoriteLeague"
                            style={marginRightValue}
                            defaultValue={favoriteLeagues ? favoriteLeagues.second_favorite_league : ''}
                            options={masterData.leagues}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="2nd Favorite League" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteLeagues', 'second_favorite_league');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="thirdfavoriteLeague"
                            style={marginRightValue}
                            defaultValue={favoriteLeagues ? favoriteLeagues.third_favorite_league : ''}
                            options={masterData.leagues}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="3rd Favorite League" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteLeagues', 'third_favorite_league');}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoriteClubteams" style={flexValue}>
                        <Autocomplete
                            id="favoriteClubteam"
                            style={marginRightValue}
                            defaultValue={favoriteClubteams ? favoriteClubteams.favorite_clubteam : ''}
                            options={clubteamsOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Clubteam" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteClubteams', 'favorite_clubteam');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="secondFavoriteClubteam"
                            style={marginRightValue}
                            defaultValue={favoriteClubteams ? favoriteClubteams.second_favorite_clubteam : ''}
                            options={clubteamsOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="2nd Favorite Clubteam" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteClubteams', 'second_favorite_clubteam');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="thirdFavoriteClubteam"
                            style={marginRightValue}
                            defaultValue={favoriteClubteams ? favoriteClubteams.third_favorite_clubteam : ''}
                            options={clubteamsOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="3rd Favorite Clubteam" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteClubteams', 'third_favorite_clubteam');}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoritePlayers" style={flexValue}>
                        <Autocomplete
                            id="favoritePlayer"
                            style={marginRightValue}
                            defaultValue={favoritePlayers ? favoritePlayers.favorite_player : ''}
                            options={playersOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Player" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePlayers', 'favorite_player');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="secondFavoritePlayer"
                            style={marginRightValue}
                            defaultValue={favoritePlayers ? favoritePlayers.second_favorite_player : ''}
                            options={playersOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="2nd Favorite Player" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePlayers', 'second_favorite_player');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="thirdFavoritePlayer"
                            style={marginRightValue}
                            defaultValue={favoritePlayers ? favoritePlayers.third_favorite_player : ''}
                            options={playersOptions.sort((a, b) => -b.category.localeCompare(a.category))}
                            groupBy={(option) => option.category}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="3rd Favorite Player" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePlayers', 'third_favorite_player');}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoriteCoaches" style={flexValue}>
                        <Autocomplete
                            id="favoriteCoach"
                            style={marginRightValue}
                            defaultValue={favoriteCoaches ? favoriteCoaches.favorite_coach : ''}
                            options={coachesOptions.sort((a, b) => -b.firstLetter.localeCompare(a.firstLetter))}
                            groupBy={(option) => option.firstLetter}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Coach" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteCoaches', 'favorite_coach');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="secondFavoriteCoach"
                            style={marginRightValue}
                            defaultValue={favoriteCoaches ? favoriteCoaches.second_favorite_coach : ''}
                            options={coachesOptions.sort((a, b) => -b.firstLetter.localeCompare(a.firstLetter))}
                            groupBy={(option) => option.firstLetter}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="2nd Favorite Coach" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteCoaches', 'second_favorite_coach');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="thirdFavoriteCoach"
                            style={marginRightValue}
                            defaultValue={favoriteCoaches ? favoriteCoaches.third_favorite_coach : ''}
                            options={coachesOptions.sort((a, b) => -b.firstLetter.localeCompare(a.firstLetter))}
                            groupBy={(option) => option.firstLetter}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="3rd Favorite Coach" />}
                            renderGroup={(params) => (
                                <li>
                                <GroupHeader>{params.group}</GroupHeader>
                                <GroupItems>{params.children}</GroupItems>
                                </li>
                            )}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteCoaches', 'third_favorite_coach');}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoritePositions" style={flexValue}>
                        <Autocomplete
                            id="favoritePosition"
                            style={marginRightValue}
                            defaultValue={favoritePositions ? favoritePositions.favorite_position : ''}
                            options={masterData.positions}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Position" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePositions', 'favorite_position');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="secondfavoritePosition"
                            style={marginRightValue}
                            defaultValue={favoritePositions ? favoritePositions.second_favorite_position : ''}
                            options={masterData.positions}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="2nd Favorite Position" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePositions', 'second_favorite_position');}}
                        >                        
                        </Autocomplete>
                        <Autocomplete
                            id="thirdfavoritePosition"
                            style={marginRightValue}
                            defaultValue={favoritePositions ? favoritePositions.third_favorite_position : ''}
                            options={masterData.positions}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="3rd Favorite Position" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePositions', 'third_favorite_position');}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoritePart" style={flexValue}>
                        <Autocomplete
                            id="favoritePart"
                            style={marginRightValue}
                            defaultValue={favoritePart ? favoritePart : ''}
                            options={masterData.favorite_parts}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Part of Football" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoritePart', null);}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="favoriteFootballGame" style={flexValue}>
                        <Autocomplete
                            id="favoriteFootballGame"
                            style={marginRightValue}
                            defaultValue={favoriteFootballGame ? favoriteFootballGame : ''}
                            options={masterData.football_games}
                            getOptionLabel={(option) => option.name}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Favorite Football Game" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setFavoriteFootballGame', null);}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="playingExperience" style={flexValue}>
                        <Autocomplete
                            id="playingExperience"
                            style={marginRightValue}
                            options={years}
                            value={playingExperience}
                            sx={{ width: 300 }}
                            renderInput={(params) => <TextField {...params} label="Playing Experience" />}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setPlayingExperience', null);}}
                        >                        
                        </Autocomplete>
                    </div><br></br>
                    <div className="aboutMe" style={flexValue}>
                        <TextareaAutosize
                            maxRows={5}
                            aria-label="maximum height"
                            placeholder="About Me"
                            defaultValue={aboutMe}
                            value={aboutMe}
                            onChange={(event, newValue) => {handleChange(event, newValue, 'setAboutMe', null);}}
                            style={{ width: 1000 }}
                        >
                        </TextareaAutosize>
                    </div><br></br>
                    <Button variant="contained" style={flexValue} onClick={setUserDetailProfile}>SAVE</Button>
                </div>
            </div>
        </div>
    )
}

export default DetailProfileSettings;