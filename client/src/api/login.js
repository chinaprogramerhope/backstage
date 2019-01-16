import request from '@/utils/request'

export function loginByUsername(userName, pass) {
  const data = {
    cmd: 6,
    param: {
      userName: userName,
      pass: pass
    }
  }

  return request({
    method: 'post',
    data
  })
}

export function logout() {
  return request({
    url: '/login/logout',
    method: 'post'
  })
}

export function getUserInfo(token) {
  return request({
    url: '/user/info',
    method: 'get',
    params: { token }
  })
}

