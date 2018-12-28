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
    // url: '/login/login',
    url: 'http://192.168.1.127:8102', // todo url定义为默认, 这里可以不用写吗
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

