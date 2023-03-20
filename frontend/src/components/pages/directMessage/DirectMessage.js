import React, { useState, useEffect, useRef } from 'react';
import { useLocation } from 'react-router-dom';
import Badge from '@mui/material/Badge';
import { ChatContainer, MessageList, Message, MessageInput, Button, ConversationHeader, Avatar, MessageSeparator } from '@chatscope/chat-ui-kit-react';
import styles from "@chatscope/chat-ui-kit-styles/dist/default/styles.min.css";
import useInterval from 'use-interval';
import { withTokenRequest, requestHeaders, multipartFormData } from '../../../http';
import { deleteBackSlash } from '../../../utils/function';
import CommonProfileCard from '../common/CommonProfileCard'; 
import noImage from "../../../assets/img/no image/noimage.png"
import Delete from '@mui/icons-material/Delete';
import styled from 'styled-components';

const DirectMessage = () => {
    const [profileCardUserId, setProfileCardUserId] = useState(null);
    const [otherUserId, setOtherUserId] = useState(null);
    const [otherName, setOtherName] = useState(null);
    const [profilePicture, setProfilePicture] = useState(null);
    const [isFetching, setIsFetching] = useState(false);
    const [displayedLatestId, setDisplayedLatestId] = useState(null);
    const [firstRequest, setFirstRequest] = useState(true);
    const [isOpenProfileCard, setIsOpenProfileCard] = useState(false);
    const [isOpenMessage, setIsOpenMessage] = useState(false);
    const [latestMessageList, setLatestMessageList] = useState([]);
    const [messages, setMessages] = useState([]);
    const [inputMessage, setInputMessage] = useState(null);
    const [picturePreview, setPicturePreview] = useState(false);
    const [pictureBlob, setPictureBlob] = useState(null);
    const [deletingMessage, setDeletingMessage] = useState(null);
    const dateCash = Date.now();
    requestHeaders.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    multipartFormData.Authorization = `${localStorage.getItem('token_type')} ${localStorage.getItem('access_token')}`;
    const location = useLocation();

    useEffect(() => {
        if (location.state) {
            let picture = noImage;
            if (location.state.picture) {
                picture = '../../storage/' + deleteBackSlash(location.state.picture) + '?' + dateCash;
            }
            openOrCloseMessage(true, location.state.user_id, location.state.name, picture);
        }
        getLatestMessageList();
    }, []);
    
    useInterval(() => {
        getLatestMessageList();
    }, 5000);

    useInterval(() => {
        if (!firstRequest && !isFetching && !deletingMessage) {
            setIsFetching(true);
            withTokenRequest.post('/getMessages', {
                user_id: localStorage.getItem('user_id'),
                other_user_id: otherUserId,
                first_request: false,
                displayed_latest_id: displayedLatestId,
            }, {
                headers: requestHeaders
            }).then((res) => {
                if (res.data.data.messages.length) {
                    res.data.data.messages.forEach(function(record) {
                        if (record.picture) {
                            record.picture = '../../storage/' + deleteBackSlash(record.picture) + "?" + dateCash;
                        }
                    })
                    setDisplayedLatestId(res.data.data.messages[res.data.data.messages.length - 1].id);
                    setMessages(prevArray => prevArray.concat(res.data.data.messages));
                    setReadMessages(res.data.data.messages[res.data.data.messages.length - 1].id, otherUserId);
                    setIsFetching(false);
                }
            })
        }
    }, 5000);

    function openOrCloseMessage(open, id, name, picture) {
        setIsOpenMessage(open);
        setOtherUserId(id);
        setOtherName(name);
        setProfilePicture(picture);
        setIsOpenProfileCard(false);
        setDisplayedLatestId(null);
        setMessages([]);
        setFirstRequest(true);
        setInputMessage(null);
        setPicturePreview(false);
        setPictureBlob(null);
        if (open) {
            getMessages(id);
        }
    }

    const getLatestMessageList = async () => {
        withTokenRequest.post('/getLatestMessageList', {
            user_id: localStorage.getItem('user_id')
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.latest_message_list) {
                res.data.data.latest_message_list.forEach(function(record) {
                    if (record.profile_picture_cropped) {
                        record.profile_picture_cropped = '../../storage/' + deleteBackSlash(record.profile_picture_cropped) + "?" + dateCash;
                    } else {
                        record.profile_picture_cropped = noImage;
                    }
                })
                setLatestMessageList([].concat(res.data.data.latest_message_list));
            } else {
                setLatestMessageList(['No Message']);
            }
        })
    }

    const addRecords = (data, other_user_id) => {
        data.messages.forEach(function(record) {
            if (record.picture) {
                record.picture = '../../storage/' + deleteBackSlash(record.picture) + "?" + dateCash;
            }
        })
        setMessages(data.messages);
        setIsFetching(false);
        if (data.messages[data.messages.length - 1].read == 0) {
            setReadMessages(data.messages[data.messages.length - 1].id, other_user_id);
        }
    }

    function getMessages(user_id) {
        setIsFetching(true);
        withTokenRequest.post('/getMessages', {
            user_id: localStorage.getItem('user_id'),
            other_user_id: user_id,
            first_request: true,
            displayed_latest_id: null,
        }, {
            headers: requestHeaders
        }).then((res) => {
            if (res.data.data.messages.length) {
                setDisplayedLatestId(res.data.data.messages[res.data.data.messages.length - 1].id);
            }
            setFirstRequest(false);
            addRecords(res.data.data, user_id);
        })
    }

    const messageGroups = groupByDate(messages);
    function groupByDate(messages) {
        return messages.reduce((groups, message) => {
            const date = new Date(message.created_at).toLocaleDateString('ja-JP', { year: 'numeric', month: '2-digit', day: '2-digit' }).split('/').reverse().join('/');
            const lastGroup = groups[groups.length - 1];
        
            if (lastGroup && lastGroup.date === date) {
              lastGroup.messages.push(message);
            } else {
              groups.push({ date, messages: [message] });
            }
            return groups;
          }, []);
    }

    const setReadMessages = async (id, other_user_id) => {
        withTokenRequest.post('/setReadMessages', {
            user_id: localStorage.getItem('user_id'),
            other_user_id: other_user_id,
            latest_to_read_id: id
        }, {
            headers: requestHeaders
        }).then(() => {

        })
    };

    function openProfileCard(other_user_id) {
        if (isOpenProfileCard && other_user_id !== profileCardUserId) {
          setProfileCardUserId(null);
          setIsOpenProfileCard(false);
          setTimeout(() => {
            setProfileCardUserId(other_user_id);
            setIsOpenProfileCard(true);
          }, 0);
        } else {
          setProfileCardUserId(other_user_id);
          setIsOpenProfileCard(true);
        }
    }

    function showPictureOriginal(pass) {
        window.open(pass);
    }

    const handleMouseEnter = (messageId) => {
        document.getElementById(`delete-button-${messageId}`).style.display = "inline";
        document.getElementById(`message-${messageId}`).style.marginLeft="5px";
      }
    
      const handleMouseLeave = (messageId) => {
        document.getElementById(`delete-button-${messageId}`).style.display = "none";
        document.getElementById(`message-${messageId}`).style.removeProperty('margin-left');
    }

    const deleteMessage = (message) => {
        setDeletingMessage(message);
        withTokenRequest.post('/deleteMessage', {
            user_id: localStorage.getItem('user_id'),
            id: message
        }, {
            headers: requestHeaders
        }).then(() => {
            setDeletingMessage(null);
            getMessages(otherUserId);
        })
    }

    const sendMessage = () => {
        let requestMessage = inputMessage;
        if (requestMessage.includes('<inputmessage>')) {
            requestMessage = requestMessage.substring(requestMessage.indexOf('<inputmessage>') + 14, requestMessage.indexOf('</inputmessage>'));
            requestMessage = requestMessage.replace(/n/, '');
        }
        if (requestMessage == '' || !requestMessage.length || requestMessage == null) {
            requestMessage = null;
        }
        const submitData = new FormData();
        submitData.append('sender_id', localStorage.getItem('user_id'));
        submitData.append('receiver_id', otherUserId);
        submitData.append('message', requestMessage);
        submitData.append('picture', pictureBlob);
        withTokenRequest.post('/sendMessage', submitData, {
            headers: multipartFormData
        }).then(() => {
            setInputMessage(null);
            setPicturePreview(false);
            setPictureBlob(null);
            getMessages(otherUserId);
        })
    }

    const handleAttachClick = () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = (event) => {
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = () => {
            setPicturePreview(true);
            setPictureBlob(file);
            setInputMessage(`
            <div style={{ position: 'relative', display: 'inline-block' }}>
                <img src="${reader.result}" alt="attachment preview" width="200" style={{ zIndex: 1 }} />
            </div><br><inputmessage>${inputMessage || ''}</inputmessage>
            `);       
          };
        };
        input.click();
    };

    function handleRemoveInputPicture() {
        let temp = inputMessage.substring(inputMessage.indexOf('<inputmessage>') + 14, inputMessage.indexOf('</inputmessage>'));
        if (temp < 0) {
            setInputMessage(null);
        } else {
            setInputMessage(temp.replace(/n/, ''));
        }
        setPicturePreview(false);
        setPictureBlob(null);
      };

    const handleChange = (innerHtml, textContent, innerText, nodes) => {
        if (inputMessage == null || !inputMessage.includes('<inputmessage></inputmessage>')) {
            setInputMessage(innerHtml);
        } else if (inputMessage.includes('<inputmessage></inputmessage>')) {
            setInputMessage(inputMessage.replace('<inputmessage></inputmessage>', '<inputmessage>' + innerText + '</inputmessage>'))
        }
    };

    const formatMessageList = (message) => {
        if (!message) {
            return;
        }
        let returnMessage = message;
        returnMessage = returnMessage.replace(/<br>/g, '');
        if (returnMessage.length > 30) {
            returnMessage = returnMessage.substr(0, 30) + '...';
        }
        return returnMessage;
    }

    const mainContentsStyle = {
        display: 'flex'
    }

    const messageListStyle = {
        border: 'solid black',
        width: '350px',
        height: '700px',
        'overflow-y': 'auto',
        'max-height': '90%',
        'margin-top': '20px',
        'margin-left': '20px'
    }

    const latestMessageListStyle = {
        cursol: 'pointer',
        display: 'flex'
    }

    const latestMessagePictureStyle = {
        width: '75px',
        height: 'auto',
        cursol: 'pointer'
    }

    const profileCardFrame = {
        margin: '20px auto',
        width: '1000px',
        'overflow-y': 'auto',
        'max-height': '90%',
    }

    const messageFrame = {
        margin: '20px auto',
        border: 'solid black',
        width: '700px',
        position: 'relative'
    };

    const styledTextArea = styled.textarea`
        width: 100%;
        height: 100%;
        resize: none;
        border: none;
        padding: 10px;
        font-size: 16px;
        box-sizing: border-box;
        white-space: pre-wrap;
        caret-color: #2a9d8f;
        `;

    let messageListMain = null;
    if (latestMessageList[0] == 'No Message') {
        messageListMain = (
            <>
                No Message
            </>
        );
    } else {
        messageListMain = (
            <>
            {latestMessageList.map((record) => (
                <div key={record.id}>
                    <div className="latestMessage" style={latestMessageListStyle}>
                        <img onClick={() => openProfileCard(record.other_user_id)} src={record.profile_picture_cropped} style={latestMessagePictureStyle}></img>
                        <div className="messageInfo" style={{clear: 'both'}} onClick={() => openOrCloseMessage(true, record.other_user_id, record.name, record.profile_picture_cropped)}>
                            <div className="firstLine" style={{display: 'flex'}}>
                                <div style={{fontWeight: 'bold', 'margin-left': '5px', float: 'left'}}>{record.name}</div>
                                <Badge badgeContent={record.unread_count} color="primary" style={{margin: '12px 0px 0px auto'}}></Badge>
                            </div>
                            <br></br>
                            <div style={{'margin-left': '5px', 'text-overflow': 'ellipsis', width: '250px', overflow: 'hidden' }}>{formatMessageList(record.message)}</div> 
                        </div>
                    </div>
                    <hr></hr>
                </div>
            ))}
            </>
        )
    }

    let messageList = null;
    messageList = (
        <div style={messageListStyle}>
            {messageListMain}
        </div>
    );

    let mainArea = null;
    if (isOpenProfileCard) {
        mainArea = (
            <>
                <div style={profileCardFrame}>
                    <CommonProfileCard isOpenProfileCard={isOpenProfileCard} 
                        setIsOpenProfileCard={setIsOpenProfileCard} 
                        user_id={profileCardUserId}
                        noDispBack={true}
                        url={'directMessage'}
                        clickMessageFunc={openOrCloseMessage}>
                    </CommonProfileCard>
                </div>
            </>
        )
    } else if (isOpenMessage) {
        console.log(messageGroups);
        mainArea = (
            <>
                <div style={messageFrame}>
                    <ChatContainer>
                        <ConversationHeader>
                            <Avatar src={profilePicture} onClick={() => openProfileCard(otherUserId)}></Avatar>
                            <ConversationHeader.Content
                                userName={otherName}
                            />
                        </ConversationHeader>
                            <MessageList style={{height: '600px'}}>
                            {messageGroups.map((group, index) => (
                                <>
                                {<MessageSeparator content={group.date}/>}
                                {group.messages.map((message) => (
                                    <>
                                        {message.sender_id == localStorage.getItem('user_id') && message.message != null && !message.picture && (
                                            <div style={{display: 'flex'}} key={message.id} onMouseEnter={() => handleMouseEnter(message.id)} onMouseLeave={() => handleMouseLeave(message.id)}>
                                                <Delete
                                                    id={`delete-button-${message.id}`}
                                                    style={{ display: 'none', cursor: 'pointer', 'margin-right': '0px', 'margin-left': 'auto' }}
                                                    onClick={() => {
                                                        if (window.confirm('Are you sure you want to delete?')) {
                                                        deleteMessage(message.id);
                                                        }
                                                    }}
                                                />
                                                <Message className="outgoing"
                                                id={`message-${message.id}`}
                                                model={{
                                                message: message.message,
                                                direction: 'outgoing',
                                                position: 'single',
                                                }}
                                                >
                                                    <Message.Footer sentTime={message.created_at.split(' ')[1]} />
                                                </Message>
                                            </div>
                                        )}
                                        {message.sender_id == localStorage.getItem('user_id') && message.message == null && message.picture && (
                                            <div style={{display: 'flex'}} key={message.id} onMouseEnter={() => handleMouseEnter(message.id)} onMouseLeave={() => handleMouseLeave(message.id)}>
                                                <Delete
                                                    id={`delete-button-${message.id}`}
                                                    style={{ display: 'none', cursor: 'pointer', 'margin-right': '0px', 'margin-left': 'auto' }}
                                                    onClick={() => {
                                                        if (window.confirm('Are you sure you want to delete?')) {
                                                        deleteMessage(message.id);
                                                        }
                                                    }}
                                                />
                                                <Message className="outgoing"
                                                id={`message-${message.id}`}
                                                model={{
                                                direction: 'outgoing',
                                                position: 'single',
                                                }}
                                                onClick={() => showPictureOriginal(message.picture)}
                                            >
                                                <Message.ImageContent src={message.picture} alt="picture" width={300} />
                                                <Message.Footer sentTime={message.created_at.split(' ')[1]} />
                                            </Message>
                                            </div>
                                        )}
                                        {message.sender_id == localStorage.getItem('user_id') && message.message != null && message.picture && (
                                            <>
                                                <div key={message.id} onMouseEnter={() => handleMouseEnter(message.id)} onMouseLeave={() => handleMouseLeave(message.id)}>
                                                    <div style={{display: 'flex'}}>
                                                        <Delete
                                                            id={`delete-button-${message.id}`}
                                                            style={{ display: 'none', cursor: 'pointer', 'margin-right': '0px', 'margin-left': 'auto' }}
                                                            onClick={() => {
                                                                if (window.confirm('Are you sure you want to delete?')) {
                                                                deleteMessage(message.id);
                                                                }
                                                            }}
                                                        />
                                                        <Message className="outgoing"
                                                        id={`message-${message.id}`}
                                                        model={{
                                                        direction: 'outgoing',
                                                        position: 'single',
                                                        }}
                                                        onClick={() => showPictureOriginal(message.picture)}
                                                    >
                                                        <Message.ImageContent src={message.picture} alt="picture" width={300} />
                                                    </Message>
                                                    </div>
                                                    <Message
                                                        model={{
                                                            message: message.message,
                                                            direction: 'outgoing',
                                                            position: 'bottom',
                                                        }}
                                                    ><Message.Footer sentTime={message.created_at.split(' ')[1]} />
                                                    </Message>
                                                </div>
                                            </>
                                        )}
                                        {message.sender_id != localStorage.getItem('user_id') && message.message != null && !message.picture && (
                                                <Message
                                                model={{
                                                message: message.message,
                                                direction: 'incoming',
                                                position: 'single',
                                                }}
                                                >
                                                    <Message.Footer sender={message.created_at.split(' ')[1]} />
                                                </Message>
                                        )}
                                        {message.sender_id != localStorage.getItem('user_id') && message.message == null && message.picture && (
                                                <Message
                                                model={{
                                                direction: 'incoming',
                                                position: 'single',
                                                }}
                                                onClick={() => showPictureOriginal(message.picture)}
                                            >
                                                <Message.ImageContent src={message.picture} alt="picture" width={300} />
                                                <Message.Footer sender={message.created_at.split(' ')[1]} />
                                            </Message>
                                        )}
                                        {message.sender_id != localStorage.getItem('user_id') && message.message != null && message.picture && (
                                            <>
                                            <Message
                                                model={{
                                                direction: 'incoming',
                                                position: 'single',
                                                }}
                                                onClick={() => showPictureOriginal(message.picture)}
                                                >
                                                    <Message.ImageContent src={message.picture} alt="picture" width={300} />
                                                </Message>
                                                <Message
                                                    model={{
                                                        message: message.message,
                                                        direction: 'incoming',
                                                        position: 'bottom',
                                                    }}
                                                >
                                                    <Message.Footer sender={message.created_at.split(' ')[1]} />
                                                </Message>
                                            </> 
                                        )}
                                    </>
                                ))}
                                </>
                            ))}
                            </MessageList>
                        <MessageInput
                            placeholder="Type your message here..."
                            multiline={true}
                            onSend={sendMessage}
                            value={inputMessage}
                            onChange={handleChange}
                            attachButton={true}
                            attachDisabled={picturePreview}
                            sendButton={true}
                            sendDisabled={false}
                            onAttachClick={handleAttachClick}
                            style={{styledTextArea}}
                         >
                        </MessageInput>
                    </ChatContainer>
                    <Delete className="deletePreview" style={{visibility: picturePreview ? 'visible' : 'hidden', width: '30px', position: 'absolute', top: '680px', left: '6px'}} onClick={handleRemoveInputPicture}></Delete>
                </div>
            </>
        )
    }

    return (
        <div style={mainContentsStyle}>
            {messageList}
            {mainArea}
        </div>
    );
}

export default DirectMessage;