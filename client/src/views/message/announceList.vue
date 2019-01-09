<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">
      <el-form-item label="开始时间:">
        <el-date-picker
          v-model="form1.dpValue1"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd HH:mm:ss"
        />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="handleSearch">搜索</el-button>
      </el-form-item>

      <el-form-item>
        <el-button @click="dialogFormAddVisible = true">+ 添加</el-button>
      </el-form-item>
    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="序号" align="center"/>
      <el-table-column prop="title" label="标题" align="center"/>
      <el-table-column prop="content" label="内容" align="center"/>
      <el-table-column prop="status" label="状态" align="center"/>
      <el-table-column prop="channel" label="渠道" align="center"/>
      <el-table-column prop="tag" label="Tag" align="center"/>
      <el-table-column prop="carousel" label="轮播" align="center"/>
      <el-table-column prop="creator" label="创建人" align="center"/>
      <el-table-column prop="note" label="备注" align="center"/>
      <el-table-column prop="publishTime" label="发布时间" align="center"/>
      <el-table-column prop="operate" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleOpenEdit(scope.row.id)">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDel(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <!-- <el-pagination
      :current-page="currentPage"
      :page-sizes="[10, 20, 30, 40]"
      :page-size="10"
      :total="40"
      layout="total, sizes, prev, pager, next, jumper"
      align="center"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
    /> -->

    <!-- dialog 添加公告 -->
    <el-dialog :visible.sync="dialogFormAddVisible" title="添加公告" center>
      <el-form :model="dialogFormAdd">

        <el-form-item :label-width="formLabelWidth" label="标题:">
          <el-input v-model="dialogFormAdd.title" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="内容:">
          <el-input
            :rows="2"
            v-model="dialogFormAdd.content"
            type="textarea"
            placeholder="请输入公告内容"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="状态">
          <el-select v-model="dialogFormAdd.selectStatus" placeholder="">
            <el-option
              v-for="item in dialogFormAdd.optionsAnnounceAddStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="是否轮播">
          <el-select v-model="dialogFormAdd.selectCarousel" placeholder="">
            <el-option
              v-for="item in dialogFormAdd.optionsCarousel"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="备注:">
          <el-input v-model="dialogFormAdd.note" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="渠道">
          <el-checkbox :indeterminate="isIndeterminateChannel" v-model="checkAllChannel" @change="handleCheckAllChannelChange">全选</el-checkbox>
          <div style="margin: 15px 0;"/>
          <el-checkbox-group v-model="checkedChannels" @change="handleCheckedChannelChange">
            <el-checkbox v-for="channelValue in channels" :label="channelValue.key" :key="channelValue.key">{{ channelValue.value }}</el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="发送区域">
          <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
          <div style="margin: 15px 0;"/>
          <el-checkbox-group v-model="checkedAreas" @change="handleCheckedAreaChange">
            <el-checkbox v-for="areaValue in areas" :label="areaValue.key" :key="areaValue.key">{{ areaValue.value }}</el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="使用终端">
          <el-select v-model="dialogFormAdd.selectTerminal" placeholder="">
            <el-option
              v-for="item in dialogFormAdd.optionsAnnounceAddTerminal"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormAddVisible = false">取 消</el-button>
        <el-button type="primary" @click="handleAdd">保 存</el-button>
      </div>
    </el-dialog>

    <!-- dialog2 编辑公告 -->
    <el-dialog :visible.sync="dialogFormEditVisible" title="编辑公告" center>
      <el-form :model="dialogFormEdit">

        <el-form-item :label-width="formLabelWidth" label="标题:">
          <el-input v-model="dialogFormEdit.title" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="内容:">
          <el-input
            :rows="2"
            v-model="dialogFormEdit.content"
            type="textarea"
            placeholder="请输入公告内容"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="状态">
          <el-select v-model="dialogFormEdit.selectStatus" placeholder="">
            <el-option
              v-for="item in dialogFormEdit.optionsAnnounceAddStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="是否轮播">
          <el-select v-model="dialogFormEdit.selectCarousel" placeholder="">
            <el-option
              v-for="item in dialogFormEdit.optionsCarousel"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="备注:">
          <el-input v-model="dialogFormEdit.note" autocomplete="off"/>
        </el-form-item>

      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormEditVisible = false">取 消</el-button>
        <el-button type="primary" @click="handleEdit">保 存</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { announceListGet } from '@/api/message'
import { announceListAdd } from '@/api/message'
import { announceListEdit } from '@/api/message'
import { announceListDel } from '@/api/message'

// checkbox 多选框
const areaOptions = [{ key: 1, value: '收件箱' }, { key: 2, value: '走马灯' }]
const channelOptions = [{ key: 1, value: '渠道1' }, { key: 2, value: '渠道2' }, { key: 3, value: '渠道3' }]

// 编辑所在行的id
var idEdit = 0

export default {
  data() {
    return {

      form1: {
        dpValue1: '',
        gameRoom: '全部',
        vipAccount: ''
      },

      // tableData
      tableData: [{
        id: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }],

      // 分页
      currentPage: 1,

      // dialog 添加公告
      dialogFormAddVisible: false,
      dialogFormAdd: {
        title: '',
        content: '',
        note: '',
        selectStatus: 1,
        selectCarousel: 1,
        selectTerminal: -1,

        optionsAnnounceAddStatus: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        optionsCarousel: [{
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }],

        optionsAnnounceAddTerminal: [{
          label: '全部',
          value: -1
        }, {
          label: '电脑端',
          value: 1
        }, {
          label: '移动端',
          value: 2
        }]
      },

      // checkbox 多选框 - 发送区域
      checkAll: false,
      checkedAreas: [],
      areas: areaOptions,
      isIndeterminate: true,

      // checkbox 多选框 - 渠道
      checkAllChannel: false,
      checkedChannels: [],
      channels: channelOptions,
      isIndeterminateChannel: true,

      formLabelWidth: '120px',

      // dialog2 编辑公告
      dialogFormEditVisible: false,
      dialogFormEdit: {
        content: '',
        note: '',
        selectStatus: 1,
        selectCarousel: 1,

        optionsAnnounceAddStatus: [{
          label: '启用',
          value: 1
        }, {
          label: '禁用',
          value: 2
        }],

        optionsCarousel: [{
          label: '是',
          value: 1
        }, {
          label: '否',
          value: 2
        }]
      }
    }
  },
  created() {
    this.announceListGetClient(this.form1.dpValue1)
  },
  methods: {
    announceListGetClient(timeBegin) {
      announceListGet(timeBegin).then(response => {
        this.tableData = response.data
      })
    },

    handleSearch() {
      this.announceListGetClient(this.form1.dpValue1)
    },

    // 添加公告
    handleAdd() {
      const title = this.dialogFormAdd.title
      const content = this.dialogFormAdd.content
      const status = this.dialogFormAdd.selectStatus
      const tagArr = this.checkedChannels
      const carousel = this.dialogFormAdd.selectCarousel
      const note = this.dialogFormAdd.note
      const areaArr = this.checkedAreas
      const terminal = this.dialogFormAdd.selectTerminal
      announceListAdd(title, content, status, tagArr, carousel, note, areaArr, terminal).then(response => {
        if (response.code === 0) {
          this.dialogFormAddVisible = false
          this.$notify({
            title: '添加公告成功',
            message: '',
            type: 'success'
          })

          // 刷新页面  todo 客户端计算刷新, 不请求服务端
          this.announceListGetClient(this.form1.dpValue1)
        } else {
          this.$notify({
            title: '添加公告失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 编辑公告
    handleEdit() {
      const title = this.dialogFormEdit.title
      const content = this.dialogFormEdit.content
      const status = this.dialogFormEdit.selectStatus
      const carousel = this.dialogFormEdit.selectCarousel
      const note = this.dialogFormEdit.note
      announceListEdit(this.idEdit, title, content, status, carousel, note).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '编辑公告成功',
            message: '',
            type: 'success'
          })

          this.dialogFormEditVisible = false

          // 刷新页面  todo 客户端计算刷新, 不请求服务端
          this.announceListGetClient(this.form1.dpValue1)
        } else {
          this.$notify({
            title: '编辑公告失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 删除公告
    handleDel(id) {
      announceListDel(id).then(response => {
        if (response.code === 0) {
          this.$notify({
            title: '删除公告成功',
            message: '',
            type: 'success'
          })

          // 刷新页面  todo 客户端计算刷新, 不请求服务端
          this.announceListGetClient(this.form1.dpValue1)
        } else {
          this.$notify({
            title: '删除公告失败',
            message: '',
            type: 'error'
          })
        }
      })
    },

    // 打开编辑页面
    handleOpenEdit(id) {
      this.dialogFormEditVisible = true
      this.idEdit = id
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    },

    // checkbox 多选框 - 发送区域
    handleCheckAllChange(val) {
      const tmpArr = []
      let i = 0
      for (const key in areaOptions) {
        tmpArr[i] = areaOptions[key].key
        ++i
      }
      this.checkedAreas = val ? tmpArr : []
      this.isIndeterminate = false
    },
    handleCheckedAreaChange(val) {
      const checkedCount = val.length
      this.checkAll = checkedCount === this.areas.length
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.areas.length
    },

    // checkbox 多选框 - 渠道
    handleCheckAllChannelChange(val) {
      const tmpArr = []
      let i = 0
      for (const key in channelOptions) {
        tmpArr[i] = channelOptions[key].key
        ++i
      }
      this.checkedChannels = val ? tmpArr : []
      this.isIndeterminateChannel = false
    },
    handleCheckedChannelChange(val) {
      const checkedCount = val.length
      this.checkAllChannel = checkedCount === this.channels.length
      this.isIndeterminateChannel = checkedCount > 0 && checkedCount < this.channels.length
    }
  }
}
</script>
